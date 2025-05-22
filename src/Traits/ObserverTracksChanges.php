<?php

declare(strict_types=1);

namespace OneOne8\LaravelAware\Traits;

use Illuminate\Database\Eloquent\Model;
use OneOne8\LaravelAware\Entities\ChangeData;
use OneOne8\LaravelAware\Enums\ChangeAction;
use OneOne8\LaravelAware\Helpers\Tracking;
use OneOne8\LaravelAware\Jobs\ProcessChanges;
use OneOne8\LaravelAware\Tracker;

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
        if (Tracking::shouldTrackManually()){
            $this->tracker = Tracker::make($model, ChangeAction::CREATE);
        }

        if (method_exists($this, 'isCreating')) {
            $this->isCreating($model);
        }
    }

    /**
     * Handle the model "created" event.
     */
    public function created(Model $model): void
    {
        if (Tracking::shouldTrackManually()){
            ProcessChanges::dispatch($this->tracker);
        }

        if (method_exists($this, 'isCreated')) {
            $this->isCreated($model);
        }
    }

    /**
     * Handle the model "deleting" event.
     */
    public function deleting(Model $model): void
    {
        if (Tracking::shouldTrackManually()){
            $this->tracker = Tracker::make($model, ChangeAction::DELETE);
        }

        if (method_exists($this, 'isDeleting')) {
            $this->isDeleting($model);
        }
    }

    /**
     * Handle the model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        if (Tracking::shouldTrackManually()){
            ProcessChanges::dispatch($this->tracker);
        }

        if (method_exists($this, 'isDeleted')) {
            $this->isDeleted($model);
        }
    }

    /**
     * Handle the model "forceDeleting" event.
     */
    public function forceDeleting(Model $model): void
    {
        if (Tracking::shouldTrackManually()){
            $this->tracker = Tracker::make($model, ChangeAction::FORCE_DELETE);
        }

        if (method_exists($this, 'isForceDeleting')) {
            $this->isForceDeleting($model);
        }
    }

    /**
     * Handle the model "forceDeleted" event.
     */
    public function forceDeleted(Model $model): void
    {
        if (Tracking::shouldTrackManually()){
            ProcessChanges::dispatch($this->tracker);
        }

        if (method_exists($this, 'isForceDeleted')) {
            $this->isForceDeleted($model);
        }
    }

    /**
     * Handle the model "restoring" event.
     */
    public function restoring(Model $model): void
    {
        if (Tracking::shouldTrackManually()){
            $this->tracker = Tracker::make($model, ChangeAction::RESTORE);
        }

        if (method_exists($this, 'isRestoring')) {
            $this->isRestoring($model);
        }
    }

    /**
     * Handle the model "restored" event.
     */
    public function restored(Model $model): void
    {
        if (Tracking::shouldTrackManually()){
            ProcessChanges::dispatch($this->tracker);
        }

        if (method_exists($this, 'isRestored')) {
            $this->isRestored($model);
        }
    }

    /**
     * Handle the model "updating" event.
     */
    public function updating(Model $model): void
    {
        if (Tracking::shouldTrackManually()){
            $this->tracker = Tracker::make($model, ChangeAction::UPDATE);
        }

        if (method_exists($this, 'isUpdating')) {
            $this->isUpdating($model);
        }
    }

    /**
     * Handle the model "updating" event.
     */
    public function updated(Model $model): void
    {
        if (Tracking::shouldTrackManually()){
            ProcessChanges::dispatch($this->tracker);
        }

        if (method_exists($this, 'isUpdated')) {
            $this->isUpdated($model);
        }
    }
}
