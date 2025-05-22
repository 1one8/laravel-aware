<?php

return [
    /**
     * Enable tracking.
     */
    'track' => env('CHANGES_TRACK', true),

    /**
     * Automatically track changes for all models.
     */
    'global' => env('CHANGES_GLOBAL', true),

    /**
     * Track only during authenticated sessions.
     */
    'authenticated' => env('CHANGES_AUTH', true),

    /**
     * Opt-out these models from tracking changes.
     *
     * Note:
     * Overrides `$model->ignoreTracking()`.
     * Overrides `$model->ignoreTrackingEvents()`.
     * Overrides `ModelIgnoresTracking` trait.
     */
    'ignore' => [],

    /**
     * Specify the queue connection and queue to use for the processing of changes.
     * Set connection to 'sync' if you want processing to happen synchronously.
     */
    'jobs' => [
        'connection' => env('CHANGES_QUEUE_CONNECTION', 'sync'),
        'queue' => env('CHANGES_QUEUE', 'default'),
    ],
];
