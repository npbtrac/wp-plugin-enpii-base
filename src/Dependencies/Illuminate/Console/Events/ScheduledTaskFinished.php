<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Console\Events;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Console\Scheduling\Event;

class ScheduledTaskFinished
{
    /**
     * The scheduled event that ran.
     *
     * @var \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Console\Scheduling\Event
     */
    public $task;

    /**
     * The runtime of the scheduled event.
     *
     * @var float
     */
    public $runtime;

    /**
     * Create a new event instance.
     *
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Console\Scheduling\Event  $task
     * @param  float  $runtime
     * @return void
     */
    public function __construct(Event $task, $runtime)
    {
        $this->task = $task;
        $this->runtime = $runtime;
    }
}
