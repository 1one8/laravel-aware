<?php

declare(strict_types=1);

namespace OneOne8\LaravelAware\Helpers;

class Queue
{
    public static function connection(): string
    {
        return config('changes.jobs.connection');
    }

    public static function queue(): string
    {
        return config('changes.jobs.queue');
    }
}
