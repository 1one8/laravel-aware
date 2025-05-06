<?php

namespace OneOne8\LaravelChanges;

use Illuminate\Database\Eloquent\Model;
use OneOne8\LaravelChanges\Entities\ChangeData;
use OneOne8\LaravelChanges\Enums\ChangeAction;
use OneOne8\LaravelChanges\Handlers\Changes;

class Tracker
{
    public static function make(Model $model, ChangeAction $action)
    {
        return new ChangeData($model, Changes::getChanges($model), $action);
    }
}
