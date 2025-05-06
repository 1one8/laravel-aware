<?php

namespace OneOne8\LaravelChanges\Jobs;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use OneOne8\LaravelChanges\Entities\ChangeData;
use OneOne8\LaravelChanges\Handlers\Actor;
use OneOne8\LaravelChanges\Handlers\Changes;
use OneOne8\LaravelChanges\Handlers\Ignore;
use OneOne8\LaravelChanges\Helpers\Queue;
use OneOne8\LaravelChanges\Helpers\Tracking;

class ProcessBulkChanges implements ShouldQueue
{
    use Queueable;

    /**
     * @param  ChangeData[]  $data
     */
    public function __construct(
        public array $data
    ) {

        $this->onConnection(Queue::connection());
        $this->onQueue(Queue::queue());
    }

    /**
     * Execute the job.
     *
     * @throws Exception
     */
    public function handle(): void
    {
        if (Tracking::shouldTrackAuthenticated()) {
            foreach ($this->data as $data) {
                if (! Ignore::model($data->model, $data->action)) {
                    Changes::by(Actor::fetch($data->model))
                        ->trackChanges(
                            $data->model,
                            $data->action,
                            $data->changes
                        );
                }
            }
        }
    }
}
