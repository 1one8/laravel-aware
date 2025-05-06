<?php

declare(strict_types=1);

namespace OneOne8\LaravelChanges\Entities;

use Illuminate\Support\Collection;

class ChangedAttributes
{
    public function __construct(
        public Collection|array $changes,
        public Collection|array $original,
        public Collection|array $changed
    ) {}
}
