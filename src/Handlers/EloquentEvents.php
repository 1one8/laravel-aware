<?php

declare(strict_types=1);

namespace OneOne8\LaravelChanges\Handlers;

use Illuminate\Support\Facades\Event;
use OneOne8\LaravelChanges\Entities\ChangeData;
use OneOne8\LaravelChanges\Enums\ChangeAction;
use OneOne8\LaravelChanges\Jobs\ProcessBulkChanges;
use OneOne8\LaravelChanges\Tracker;

/**
 * @property ChangeData[] $trackers
 */
class EloquentEvents
{
    protected array $trackers = [];

    public static function make(): static
    {
        return new static;
    }

    public function watch(): void
    {
        Event::listen(
            ['eloquent.creating: *'],
            function (
                string $eventName,
                array $data
            ) {
                return $this->track($data, ChangeAction::CREATE);
            }
        );

        Event::listen(
            ['eloquent.created: *'],
            function () {
                ProcessBulkChanges::dispatch($this->trackers);
            }
        );

        Event::listen(
            ['eloquent.deleting: *'],
            function (
                string $eventName,
                array $data
            ) {
                return $this->track($data, ChangeAction::DELETE);
            }
        );

        Event::listen(
            ['eloquent.deleted: *'],
            function () {
                ProcessBulkChanges::dispatch($this->trackers);
            }
        );

        Event::listen(
            ['eloquent.forceDeleting: *'],
            function (
                string $eventName,
                array $data
            ) {
                return $this->track($data, ChangeAction::FORCE_DELETE);
            }
        );

        Event::listen(
            ['eloquent.forceDeleted: *'],
            function () {
                ProcessBulkChanges::dispatch($this->trackers);
            }
        );

        Event::listen(
            ['eloquent.updating: *'],
            function (
                string $eventName,
                array $data
            ) {
                return $this->track($data, ChangeAction::UPDATE);
            }
        );

        Event::listen(
            ['eloquent.updated: *'],
            function () {
                ProcessBulkChanges::dispatch($this->trackers);
            }
        );

        Event::listen(
            ['eloquent.restoring: *'],
            function (
                string $eventName,
                array $data
            ) {
                return $this->track($data, ChangeAction::RESTORE);
            }
        );

        Event::listen(
            ['eloquent.restored: *'],
            function () {
                ProcessBulkChanges::dispatch($this->trackers);
            }
        );
    }

    private function track(array $data, ChangeAction $action): bool
    {
        return $this->walk(
            $data,
            $action
        );
    }

    private function walk(
        array $data,
        ChangeAction $action
    ): bool {
        foreach ($data as $model) {
            $this->trackers[] = Tracker::make($model, $action);
        }

        return true;
    }
}
