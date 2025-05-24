<?php

declare(strict_types=1);

namespace OneOne8\LaravelAware\Helpers;

use Illuminate\Database\Eloquent\Model;
use OneOne8\LaravelAware\Enums\ChangeAction;
use OneOne8\LaravelAware\Models\Change;

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
            config('aware.ignore')
        )) {
            $ignore = true;
        }

        return $ignore;
    }
}
