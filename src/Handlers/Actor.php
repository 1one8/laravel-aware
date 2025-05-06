<?php

declare(strict_types=1);

namespace OneOne8\LaravelChanges\Handlers;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OneOne8\LaravelChanges\Entities\ChangeActor;

class Actor
{
    /**
     * @throws Exception
     */
    public static function fetch(?Model $model = null): ChangeActor
    {
        if ($model !== null && method_exists(
            $model,
            'getActor'
        )) {
            return $model::getActor();
        }

        return self::authActor();
    }

    /**
     * @throws Exception
     */
    public static function make(
        object|string $actor,
        ?string $actorId = null
    ): ChangeActor {
        if (is_string($actor) && class_exists($actor)) {
            return new ChangeActor(
                $actor,
                $actorId
            );
        }

        $id = $actor->id ?? $actorId;

        return new ChangeActor(
            get_class($actor),
            $id
        );
    }

    /**
     * @throws Exception
     */
    private static function authActor(): ChangeActor
    {
        $user = Auth::user();

        return new ChangeActor(
            get_class($user),
            Auth::id()
        );
    }
}
