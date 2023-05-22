<?php

namespace Enpii_Base\Deps\Illuminate\Queue\Events;

class JobProcessing
{
    /**
     * The connection name.
     *
     * @var string
     */
    public $connectionName;

    /**
     * The job instance.
     *
     * @var \Enpii_Base\Deps\Illuminate\Contracts\Queue\Job
     */
    public $job;

    /**
     * Create a new event instance.
     *
     * @param  string  $connectionName
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Queue\Job  $job
     * @return void
     */
    public function __construct($connectionName, $job)
    {
        $this->job = $job;
        $this->connectionName = $connectionName;
    }
}
