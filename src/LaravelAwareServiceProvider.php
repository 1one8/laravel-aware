<?php

namespace OneOne8\LaravelAware;

use OneOne8\LaravelAware\Helpers\Tracking;
use OneOne8\LaravelAware\Processors\EloquentEvents;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelAwareServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-aware')
            ->hasConfigFile()
            ->discoversMigrations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->startWith(function (InstallCommand $command) {
                        $command->info('Hello, let\'s get aware installed!');
                    })
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToStarRepoOnGitHub('1one8/laravel-aware');
            });
    }

    public function bootingPackage()
    {
        if (Tracking::shouldTrackGlobal()) {
            EloquentEvents::make()->listen();
        }
    }
}
