<?php

declare(strict_types=1);

namespace OneOne8\LaravelAware\Helpers;

use Illuminate\Support\Facades\Auth;

class Tracking
{
    public static function shouldTrack(): bool
    {
        return config('changes.track');
    }

    public static function shouldTrackGlobal(): bool
    {
        return config('changes.track') && config('changes.global');
    }

    public static function shouldTrackManually(): bool
    {
        return config('changes.track') && !config('changes.global');
    }

    public static function shouldTrackAuthenticated(): bool
    {
        $track = ! config('changes.authenticated') || Auth::check();

        return static::shouldTrack() && $track;
    }
}
