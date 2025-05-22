<?php

declare(strict_types=1);

namespace OneOne8\LaravelAware;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use OneOne8\LaravelAware\Enums\ChangeAction;
use OneOne8\LaravelAware\Models\Change;

class Who
{
    public static function created(
        string $referenceType,
        ?string $referenceId = null
    ) {
        return self::getActorResult(
            $referenceType,
            ChangeAction::CREATE,
            $referenceId
        );
    }

    public static function deleted(
        string $referenceType,
        ?string $referenceId = null
    ) {
        return self::getActorResult(
            $referenceType,
            ChangeAction::DELETE,
            $referenceId
        );
    }

    public static function forceDeleted(
        string $referenceType,
        ?string $referenceId = null
    ) {
        return self::getActorResult(
            $referenceType,
            ChangeAction::FORCE_DELETE,
            $referenceId
        );
    }

    public static function restored(
        string $referenceType,
        ?string $referenceId = null
    ) {
        return self::getActorResult(
            $referenceType,
            ChangeAction::RESTORE,
            $referenceId
        );
    }

    public static function updated(
        string $referenceType,
        ?string $referenceId = null
    ) {
        return self::getActorResult(
            $referenceType,
            ChangeAction::UPDATE,
            $referenceId
        );
    }

    private static function getActorResult(
        string $referenceType,
        ChangeAction $action,
        ?string $referenceId = null
    ): null|Collection|Model {
        $changes = self::getQuery(
            $referenceType,
            $action,
            $referenceId
        );

        if ($changes->isEmpty()) {
            return null;
        }

        if ($changes instanceof EloquentCollection) {
            return $changes->pluck('actor');
        }

        return $changes->actor;
    }

    private static function getQuery(
        string $referenceType,
        ChangeAction $action,
        ?string $referenceId = null
    ): EloquentCollection {
        $changes = Change::where(
            'reference_type',
            $referenceType
        )
            ->where(
                'action',
                $action
            );

        if (! empty($referenceId)) {
            $changes = $changes->where(
                'reference_id',
                $referenceId
            );
        }

        if ($action == ChangeAction::CREATE) {
            return $changes->first();
        }

        return $changes->get();
    }
}
