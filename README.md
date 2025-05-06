# A simple auditing package to keep track of your Eloquent model changes

[![Latest Version on Packagist](https://img.shields.io/packagist/v/1one8/laravel-changes.svg?style=flat-square)](https://packagist.org/packages/1one8/laravel-changes)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/1one8/laravel-changes/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/1one8/laravel-changes/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/1one8/laravel-changes/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/1one8/laravel-changes/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/1one8/laravel-changes.svg?style=flat-square)](https://packagist.org/packages/1one8/laravel-changes)

### This package is still under development!

## Installation

You can install the package via composer:

```bash
composer require one-one-8/laravel-changes
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-changes-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-changes-config"
```

This is the contents of the published config file:

```php
return [
    /**
     * Enable tracking.
     */
    'track' => true,

    /**
     * Automatically track changes for all models.
     */
    'global' => true,

    /**
     * Track only during authenticated sessions.
     */
    'authenticated' => true,

    /**
     * Opt-out these models from tracking changes.
     *
     * Note:
     * Overrides '$model->ignoreTracking()`.
     * Overrides 'ModelIgnoresTracking` trait.
     */
    'ignore' => [],

    /**
     * Specify the queue connection and queue to use for the processing of changes.
     * Set connection to 'sync' if you want processing to happen synchronously.
     */
    'jobs' => [
        'connection' => env('CHANGES_QUEUE_CONNECTION', 'database'),
        'queue' => env('CHANGES_QUEUE', 'default')
    ],
];
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Charl Gottschalk](https://github.com/CharlGottschalk)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
