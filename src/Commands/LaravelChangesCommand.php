<?php

namespace OneOne8\LaravelChanges\Commands;

use Illuminate\Console\Command;

class LaravelChangesCommand extends Command
{
    public $signature = 'laravel-changes';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
