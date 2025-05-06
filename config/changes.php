<?php

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
        'queue' => env('CHANGES_QUEUE', 'default'),
    ],
];
