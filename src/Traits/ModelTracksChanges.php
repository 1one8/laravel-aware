<?php

declare(strict_types=1);

namespace OneOne8\LaravelAware\Traits;

use Illuminate\Database\Eloquent\Model;
use OneOne8\LaravelAware\Entities\ChangeData;
use OneOne8\LaravelAware\Enums\ChangeAction;
use OneOne8\LaravelAware\Helpers\Tracking;
use OneOne8\LaravelAware\Jobs\ProcessChanges;
use OneOne8\LaravelAware\Tracker;

/**
 * @method static void creating(callable $callback)
 * @method static void created(callable $callback)
 * @method static void updating(callable $callback)
 * @method static void updated(callable $callback)
 * @method static void deleting(callable $callback)
 * @method static void deleted(callable $callback)
 * @method static void forceDeleting(callable $callback)
 * @method static void forceDeleted(callable $callback)
 * @method static void restoring(callable $callback)
 * @method static void restored(callable $callback)
 */
trait ModelTracksChanges
{
    protected ChangeData $tracker;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        if (Tracking::shouldTrackManually()) {

            self::creating(function (Model $model) {
                $this->tracker = Tracker::make($model, ChangeAction::CREATE);
            });

            self::created(function () {
                ProcessChanges::dispatch($this->tracker);

                return true;
            });

            self::updating(function (Model $model) {
                $this->tracker = Tracker::make($model, ChangeAction::UPDATE);
            });

            self::updated(function () {
                ProcessChanges::dispatch($this->tracker);

                return true;
            });

            self::deleting(function (Model $model) {
                $this->tracker = Tracker::make($model, ChangeAction::DELETE);
            });

            self::deleted(function () {
                ProcessChanges::dispatch($this->tracker);
            });

            self::forceDeleting(function (Model $model) {
                $this->tracker = Tracker::make($model, ChangeAction::FORCE_DELETE);
            });

            self::forceDeleted(function () {
                ProcessChanges::dispatch($this->tracker);
            });

            self::restoring(function (Model $model) {
                $this->tracker = Tracker::make($model, ChangeAction::RESTORE);
            });

            self::restored(function () {
                ProcessChanges::dispatch($this->tracker);
            });
        }
    }
}
