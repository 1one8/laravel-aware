<?php

declare(strict_types=1);

namespace OneOne8\LaravelChanges\Traits;

use Exception;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use OneOne8\LaravelChanges\Entities\ChangeActor;
use OneOne8\LaravelChanges\Handlers\Actor;
use OneOne8\LaravelChanges\Models\Change;

/**
 * @method MorphMany morphMany(string $model, string $column)
 */
trait ModelHasChanges
{
    private static ?ChangeActor $changeActor = null;

    /**
     * @throws Exception
     */
    public static function getActor(): ChangeActor
    {
        if (empty(self::$changeActor)) {
            self::$changeActor = Actor::fetch();
        }

        return self::$changeActor;
    }

    /**
     * @throws Exception
     */
    public static function setActor(
        object $actor,
        ?int $actorId = null
    ): void {
        self::$changeActor = Actor::make(
            $actor,
            $actorId
        );
    }

    public function changes(): MorphMany
    {
        return $this->morphMany(
            Change::class,
            'reference'
        );
    }
}
