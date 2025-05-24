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
        if (Tracking::shouldTrackManually()) {
            $this->tracker = Tracker::make($model, ChangeAction::CREATE);
        }

        $this->callAwareMethod(
            method: 'isCreating',
            model: $model
        );
    }

    /**
     * Handle the model "created" event.
     */
    public function created(Model $model): void
    {
        if (Tracking::shouldTrackManually()) {
            ProcessChanges::dispatch($this->tracker);
        }

        $this->callAwareMethod(
            method: 'isCreated',
            model: $model
        );
    }

    /**
     * Handle the model "deleting" event.
     */
    public function deleting(Model $model): void
    {
        if (Tracking::shouldTrackManually()) {
            $this->tracker = Tracker::make($model, ChangeAction::DELETE);
        }

        $this->callAwareMethod(
            method: 'isDeleting',
            model: $model
        );
    }

    /**
     * Handle the model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        if (Tracking::shouldTrackManually()) {
            ProcessChanges::dispatch($this->tracker);
        }

        $this->callAwareMethod(
            method: 'isDeleted',
            model: $model
        );
    }

    /**
     * Handle the model "forceDeleting" event.
     */
    public function forceDeleting(Model $model): void
    {
        if (Tracking::shouldTrackManually()) {
            $this->tracker = Tracker::make($model, ChangeAction::FORCE_DELETE);
        }

        $this->callAwareMethod(
            method: 'isForceDeleting',
            model: $model
        );
    }

    /**
     * Handle the model "forceDeleted" event.
     */
    public function forceDeleted(Model $model): void
    {
        if (Tracking::shouldTrackManually()) {
            ProcessChanges::dispatch($this->tracker);
        }

        $this->callAwareMethod(
            method: 'isForceDeleted',
            model: $model
        );
    }

    /**
     * Handle the model "restoring" event.
     */
    public function restoring(Model $model): void
    {
        if (Tracking::shouldTrackManually()) {
            $this->tracker = Tracker::make($model, ChangeAction::RESTORE);
        }

        $this->callAwareMethod(
            method: 'isRestoring',
            model: $model
        );
    }

    /**
     * Handle the model "restored" event.
     */
    public function restored(Model $model): void
    {
        if (Tracking::shouldTrackManually()) {
            ProcessChanges::dispatch($this->tracker);
        }

        $this->callAwareMethod(
            method: 'isRestored',
            model: $model
        );
    }

    /**
     * Handle the model "updating" event.
     */
    public function updating(Model $model): void
    {
        if (Tracking::shouldTrackManually()) {
            $this->tracker = Tracker::make($model, ChangeAction::UPDATE);
        }

        $this->callAwareMethod(
            method: 'isUpdating',
            model: $model
        );
    }

    /**
     * Handle the model "updating" event.
     */
    public function updated(Model $model): void
    {
        if (Tracking::shouldTrackManually()) {
            ProcessChanges::dispatch($this->tracker);
        }

        $this->callAwareMethod(
            method: 'isUpdated',
            model: $model
        );
    }

    private function callAwareMethod(string $method, Model $model): void
    {
        if (method_exists($this, $method)) {
            $this->{$method}($model);
        }
    }
}
