<?php

namespace Enpii_Base\Deps\Illuminate\Console\Events;

use Enpii_Base\Deps\Illuminate\Console\Scheduling\Event;
use Throwable;

class ScheduledTaskFailed
{
    /**
     * The scheduled event that failed.
     *
     * @var \Enpii_Base\Deps\Illuminate\Console\Scheduling\Event
     */
    public $task;

    /**
     * The exception that was thrown.
     *
     * @var \Throwable
     */
    public $exception;

    /**
     * Create a new event instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Console\Scheduling\Event  $task
     * @param  \Throwable  $exception
     */
    public function __construct(Event $task, Throwable $exception)
    {
        $this->task = $task;
        $this->exception = $exception;
    }
}