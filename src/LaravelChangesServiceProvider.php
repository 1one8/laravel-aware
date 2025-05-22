<?php

namespace OneOne8\LaravelAware;

use OneOne8\LaravelAware\Commands\LaravelAwareCommand;
use OneOne8\LaravelAware\Processors\EloquentEvents;
use OneOne8\LaravelAware\Helpers\Tracking;
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
            ->hasMigration('create_changes_table');
    }

    public function bootingPackage()
    {
        if (Tracking::shouldTrackGlobal()) {
            EloquentEvents::make()->listen();
        }
    }
}
