<?php

declare(strict_types=1);

namespace OneOne8\LaravelAware\Processors;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use OneOne8\LaravelAware\Entities\ChangeActor;
use OneOne8\LaravelAware\Entities\ChangedAttributes;
use OneOne8\LaravelAware\Enums\ChangeAction;
use OneOne8\LaravelAware\Enums\ChangedUsing;
use OneOne8\LaravelAware\Events\TrackingChangesCompleted;
use OneOne8\LaravelAware\Events\TrackingChangesFailed;
use OneOne8\LaravelAware\Events\TrackingChangesStarted;
use OneOne8\LaravelAware\Models\Change;
use Throwable;

class Changes
{
    public function __construct(
        private ChangeActor $actor
    ) {}

    public static function by(
        object $actor,
        ?int $actorId = null
    ): Changes {
        if ($actor instanceof ChangeActor) {
            return new self($actor);
        }

        $id = $actor->id ?? $actorId;

        return new self(
            new ChangeActor(
                get_class($actor),
                $id
            )
        );
    }

    protected static function applyChanges(
        ChangedAttributes $changes,
        Model $model
    ): void {
        $model->fill($changes->changes);
        $model->saveQuietly();
    }

    protected function changedUsing(): ChangedUsing
    {
        if (APP::runningInConsole()) {
            return ChangedUsing::CONSOLE;
        }

        if (request()->wantsJson()) {
            return ChangedUsing::API;
        }

        return ChangedUsing::WEB;
    }

    protected static function collect(
        array $attributes
    ): Collection {
        return collect($attributes)
            ->filter(
                function (
                    $value,
                    $key
                ) {
                    return ! in_array(
                        $key,
                        [
                            'created_at',
                            'updated_at',
                            'deleted_at',
                        ]
                    );
                }
            )
            ->mapWithKeys(
                function (
                    $value,
                    $key
                ) {
                    return [$key => $value];
                }
            );
    }

    /**
     * Get the model's changes.
     */
    public static function getChanges(
        Model $model
    ): ChangedAttributes {
        $changes = static::collect($model->getDirty())
            ->toArray();

        $original = static::collect($model->getOriginal())
            ->toArray();

        if (empty($original)) {
            $original = $changes;
        }

        $changed = [];
        $old = [];

        foreach ($original as $key => $value) {
            if (array_key_exists(
                $key,
                $changes
            )) {
                $changed[] = [
                    'column' => $key,
                    'from' => $value,
                    'to' => $changes[$key],
                ];

                $old[$key] = $value;
            }
        }

        return new ChangedAttributes(
            changes : $changes,
            original: $old,
            changed : $changed
        );
    }

    /**
     * Get the changes record.
     */
    protected function getRecord(
        Model $model,
        ChangedAttributes $changes,
        ChangeAction $action
    ): array {
        if (is_array($changes->original)) {
            $from = $changes->original;
        } else {
            $from = $changes->original->toArray();
        }

        if (empty($from)) {
            if (is_array($changes->changes)) {
                $from = $changes->changes;
            } else {
                $from = $changes->changes->toArray();
            }
        }

        if (is_array($changes->changes)) {
            $changedTo = $changes->changes;
        } else {
            $changedTo = $changes->changes->toArray();
        }

        if (is_array($changes->changed)) {
            $changed = $changes->changed;
        } else {
            $changed = $changes->changed->toArray();
        }

        $changedUsing = $this->changedUsing();

        return [
            'actor_id' => $this->actor->actorId,
            'actor_type' => $this->actor->actorClass,
            'reference_id' => $model->getKey(),
            'reference_type' => get_class($model),
            'changed_from' => $from,
            'changed_to' => $changedTo,
            'changes' => $changed,
            'changed_using' => $changedUsing,
            'changed_with' => $changedUsing === ChangedUsing::CONSOLE ? $changedUsing->value : Route::currentRouteAction(),
            'ip_address' => request()->ip(),
            'action' => $action,
            'changed_at' => Carbon::now(),
        ];
    }

    /**
     * Track the model changes.
     */
    public function trackChanges(
        Model $model,
        ChangeAction $action,
        ChangedAttributes $changes
    ): void {
        $record = $this->getRecord(
            $model,
            $changes,
            $action
        );

        TrackingChangesStarted::dispatch($model, $record);

        try {
            Change::withoutEvents(
                function () use (
                    $model,
                    $record
                ) {
                    $change = Change::create($record);
                    TrackingChangesCompleted::dispatch($model, $change);
                }
            );
        } catch (Throwable $e) {
            TrackingChangesFailed::dispatch($model, $changes, $e);
        }
    }
}
