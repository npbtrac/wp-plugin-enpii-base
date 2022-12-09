<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Console\Events;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Console\Scheduling\Event;

class ScheduledTaskStarting
{
    /**
     * The scheduled event being run.
     *
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Console\Scheduling\Event
     */
    public $task;

    /**
     * Create a new event instance.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Console\Scheduling\Event  $task
     * @return void
     */
    public function __construct(Event $task)
    {
        $this->task = $task;
    }
}
