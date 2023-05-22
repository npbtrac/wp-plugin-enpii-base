<?php

namespace Enpii_Base\Deps\Illuminate\Foundation\Console;

use Enpii_Base\Deps\Illuminate\Bus\Queueable;
use Enpii_Base\Deps\Illuminate\Contracts\Console\Kernel as KernelContract;
use Enpii_Base\Deps\Illuminate\Contracts\Queue\ShouldQueue;
use Enpii_Base\Deps\Illuminate\Foundation\Bus\Dispatchable;

class QueuedCommand implements ShouldQueue
{
    use Dispatchable, Queueable;

    /**
     * The data to pass to the Artisan command.
     *
     * @var array
     */
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param  array  $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Handle the job.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Console\Kernel  $kernel
     * @return void
     */
    public function handle(KernelContract $kernel)
    {
        $kernel->call(...array_values($this->data));
    }
}
