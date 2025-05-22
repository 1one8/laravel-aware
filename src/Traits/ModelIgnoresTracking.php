<?php

declare(strict_types=1);

namespace OneOne8\LaravelAware\Traits;

use OneOne8\LaravelAware\Enums\ChangeAction;

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
