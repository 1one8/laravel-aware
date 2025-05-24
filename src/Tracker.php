<?php

namespace OneOne8\LaravelAware;

use Illuminate\Database\Eloquent\Model;
use OneOne8\LaravelAware\Entities\ChangeData;
use OneOne8\LaravelAware\Enums\ChangeAction;
use OneOne8\LaravelAware\Processors\Changes;

class Tracker
{
    public static function make(Model $model, ChangeAction $action): ChangeData
    {
        return new ChangeData($model, Changes::getChanges($model), $action);
    }
}
