<?php

namespace Enpii_Base\Deps\Illuminate\Foundation\Bus;

use Enpii_Base\Deps\Illuminate\Contracts\Bus\Dispatcher;

trait DispatchesJobs
{
    /**
     * Dispatch a job to its appropriate handler.
     *
     * @param  mixed  $job
     * @return mixed
     */
    protected function dispatch($job)
    {
        return wp_app(Dispatcher::class)->dispatch($job);
    }

    /**
     * Dispatch a job to its appropriate handler in the current process.
     *
     * @param  mixed  $job
     * @return mixed
     */
    public function dispatchNow($job)
    {
        return wp_app(Dispatcher::class)->dispatchNow($job);
    }
}
