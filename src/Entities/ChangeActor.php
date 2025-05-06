<?php

declare(strict_types=1);

namespace OneOne8\LaravelChanges\Entities;

class ChangeActor
{
    public function __construct(
        public ?string $actorClass,
        public null|int|string $actorId
    ) {}
}
