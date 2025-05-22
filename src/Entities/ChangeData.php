<?php

namespace OneOne8\LaravelAware\Entities;

use Illuminate\Database\Eloquent\Model;
use OneOne8\LaravelAware\Enums\ChangeAction;

class ChangeData
{
    public function __construct(
        public Model $model,
        public ChangedAttributes $changes,
        public ChangeAction $action
    ) {}
}
