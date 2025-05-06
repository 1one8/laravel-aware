<?php

namespace OneOne8\LaravelChanges;

use OneOne8\LaravelChanges\Commands\LaravelChangesCommand;
use OneOne8\LaravelChanges\Handlers\EloquentEvents;
use OneOne8\LaravelChanges\Helpers\Tracking;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelChangesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-changes')
            ->hasConfigFile()
            ->hasMigration('create_changes_table')
            ->hasCommand(LaravelChangesCommand::class);
    }

    public function bootingPackage()
    {
        if (Tracking::shouldTrackGlobal()) {
            EloquentEvents::make()->watch();
        }
    }
}
