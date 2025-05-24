<?php

declare(strict_types=1);

namespace OneOne8\LaravelAware\Helpers;

use Illuminate\Support\Facades\Auth;

class Tracking
{
    public static function shouldTrack(): bool
    {
        if (config('aware.authenticated')) {
            return config('aware.track') && Auth::check();
        }

        return config('aware.track');
    }

    public static function shouldTrackGlobal(): bool
    {
        return static::shouldTrack() && config('aware.global');
    }

    public static function shouldTrackManually(): bool
    {
        return static::shouldTrack() && ! config('aware.global');
    }
}
