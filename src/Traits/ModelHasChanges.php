<?php

declare(strict_types=1);

namespace OneOne8\LaravelAware\Traits;

use Exception;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use OneOne8\LaravelAware\Entities\ChangeActor;
use OneOne8\LaravelAware\Helpers\Actor;
use OneOne8\LaravelAware\Models\Change;

/**
 * @method MorphMany morphMany(string $model, string $column)
 */
trait ModelHasChanges
{
    public function changes(): MorphMany
    {
        return $this->morphMany(
            Change::class,
            'reference'
        );
    }
}
