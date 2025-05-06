<?php

declare(strict_types=1);

namespace OneOne8\LaravelChanges\Handlers;

use Illuminate\Database\Eloquent\Model;
use OneOne8\LaravelChanges\Enums\ChangeAction;
use OneOne8\LaravelChanges\Models\Change;

class Ignore
{
    public static function model(Model $model, ChangeAction $action): bool
    {
        if ($model instanceof Change) {
            return true;
        }

        $ignore = false;

        if (method_exists(
            $model,
            'ignoreTracking'
        )) {
            $ignore = $model->ignoreTracking();
        }

        if (method_exists(
            $model,
            'ignoreTrackingEvents'
        )) {
            $ignore = in_array($action->value, $model->ignoreTrackingEvents());
        }

        if (in_array(
            get_class($model),
            config('changes.ignore')
        )) {
            $ignore = true;
        }

        return $ignore;
    }
}
