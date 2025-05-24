<?php

declare(strict_types=1);

namespace OneOne8\LaravelAware\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use OneOne8\LaravelAware\Entities\ChangedAttributes;
use Throwable;

class TrackingChangesFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Model $model,
        public ChangedAttributes $changes,
        public Throwable $exception,
    ) {
        //
    }
}
