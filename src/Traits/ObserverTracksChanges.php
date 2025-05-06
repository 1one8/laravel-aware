<?php

declare(strict_types=1);

namespace OneOne8\LaravelChanges\Traits;

use Illuminate\Database\Eloquent\Model;
use OneOne8\LaravelChanges\Entities\ChangeData;
use OneOne8\LaravelChanges\Enums\ChangeAction;
use OneOne8\LaravelChanges\Jobs\ProcessChanges;
use OneOne8\LaravelChanges\Tracker;

trait ObserverTracksChanges
{
    protected ChangeData $tracker;

    /**
     * Handle events after all transactions are committed.
     */
    public bool $afterCommit = true;

    /**
     * Handle the model "creating" event.
     */
    public function creating(Model $model): void
    {
        $this->tracker = Tracker::make($model, ChangeAction::CREATE);
    }

    /**
     * Handle the model "created" event.
     */
    public function created(Model $model): void
    {
        ProcessChanges::dispatch($this->tracker);

        if (method_exists($this, 'isCreated')) {
            $this->isCreated($model);
        }
    }

    /**
     * Handle the model "deleting" event.
     */
    public function deleting(Model $model): void
    {
        $this->tracker = Tracker::make($model, ChangeAction::DELETE);
    }

    /**
     * Handle the model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        ProcessChanges::dispatch($this->tracker);

        if (method_exists($this, 'isDeleted')) {
            $this->isDeleted($model);
        }
    }

    /**
     * Handle the model "forceDeleting" event.
     */
    public function forceDeleting(Model $model): void
    {
        $this->tracker = Tracker::make($model, ChangeAction::FORCE_DELETE);
    }

    /**
     * Handle the model "force deleting" event.
     */
    public function forceDeleted(Model $model): void
    {
        ProcessChanges::dispatch($this->tracker);

        if (method_exists($this, 'isForceDeleted')) {
            $this->isForceDeleted($model);
        }
    }

    /**
     * Handle the model "restoring" event.
     */
    public function restoring(Model $model): void
    {
        $this->tracker = Tracker::make($model, ChangeAction::RESTORE);
    }

    /**
     * Handle the model "restored" event.
     */
    public function restored(Model $model): void
    {
        ProcessChanges::dispatch($this->tracker);

        if (method_exists($this, 'isRestored')) {
            $this->isRestored($model);
        }
    }

    /**
     * Handle the model "updating" event.
     */
    public function updating(Model $model): void
    {
        $this->tracker = Tracker::make($model, ChangeAction::UPDATE);
    }

    /**
     * Handle the model "updating" event.
     */
    public function updated(Model $model): void
    {
        ProcessChanges::dispatch($this->tracker);

        if (method_exists($this, 'isUpdated')) {
            $this->isUpdated($model);
        }
    }
}
