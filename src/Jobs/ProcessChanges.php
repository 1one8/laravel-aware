<?php

namespace OneOne8\LaravelAware\Jobs;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use OneOne8\LaravelAware\Entities\ChangeData;
use OneOne8\LaravelAware\Helpers\Actor;
use OneOne8\LaravelAware\Helpers\Ignore;
use OneOne8\LaravelAware\Helpers\Queue;
use OneOne8\LaravelAware\Helpers\Tracking;
use OneOne8\LaravelAware\Processors\Changes;

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
