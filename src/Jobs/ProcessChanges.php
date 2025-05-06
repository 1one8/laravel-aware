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

class ProcessChanges implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public ChangeData $data
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
            if (! Ignore::model($this->data->model, $this->data->action)) {
                Changes::by(Actor::fetch($this->data->model))
                    ->trackChanges(
                        $this->data->model,
                        $this->data->action,
                        $this->data->changes
                    );
            }
        }
    }
}
