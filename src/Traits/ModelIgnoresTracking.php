<?php

declare(strict_types=1);

namespace OneOne8\LaravelChanges\Traits;

use OneOne8\LaravelChanges\Enums\ChangeAction;

trait ModelIgnoresTracking
{
    public function ignoreTracking(): bool
    {
        return true;
    }

    public function ignoreTrackingEvents(): array
    {
        return ChangeAction::values();
    }
}
