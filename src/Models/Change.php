<?php

declare(strict_types=1);

namespace OneOne8\LaravelAware\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use OneOne8\LaravelAware\Entities\ChangedAttributes;
use OneOne8\LaravelAware\Enums\ChangeAction;
use OneOne8\LaravelAware\Enums\ChangedUsing;

/**
 * Class representing an entity.
 *
 * @property int $id
 * @property string $actor_type
 * @property string $actor_id
 * @property string $reference_type
 * @property string $reference_id
 * @property string|null $ip_address
 * @property array|null $changed_from
 * @property array|null $changed_to
 * @property array|null $changes
 * @property string|null $changed_with
 * @property ChangeAction $action
 * @property ChangedUsing $changed_using
 * @property Carbon $changed_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Change extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'action' => ChangeAction::class,
        'changed_using' => ChangedUsing::class,
        'changed_at' => 'datetime',
        'changed_from' => 'array',
        'changed_to' => 'array',
        'changes' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'actor_id',
        'actor_type',
        'reference_id',
        'reference_type',
        'ip_address',
        'changed_using',
        'changed_with',
        'changed_from',
        'changed_to',
        'changes',
        'action',
        'changed_at',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'actor',
        'reference',
    ];

    /**
     * Get the owning actor model.
     */
    public function actor(): MorphTo
    {
        return $this->morphTo();
    }

    public function getChangedAttributes(): ChangedAttributes
    {
        return new ChangedAttributes(
            changes : $this->changed_to,
            original: $this->changed_from,
            changed : $this->changes
        );
    }

    public function ignoreTracking(): bool
    {
        return true;
    }

    /**
     * Get the owning reference model.
     */
    public function reference(): MorphTo
    {
        return $this->morphTo();
    }
}
