<?php

namespace OneOne8\LaravelChanges\Entities;

use Illuminate\Database\Eloquent\Model;
use OneOne8\LaravelChanges\Enums\ChangeAction;

class ChangeData
{
    public function __construct(
        public Model $model,
        public ChangedAttributes $changes,
        public ChangeAction $action
    ) {}
}
