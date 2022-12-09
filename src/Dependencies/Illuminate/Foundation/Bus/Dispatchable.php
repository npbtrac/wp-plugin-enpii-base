<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bus;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Bus\Dispatcher;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Fluent;

trait Dispatchable
{
    /**
     * Dispatch the job with the given arguments.
     *
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bus\PendingDispatch
     */
    public static function dispatch()
    {
        return new PendingDispatch(new static(...func_get_args()));
    }

    /**
     * Dispatch the job with the given arguments if the given truth test passes.
     *
     * @param  bool  $boolean
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bus\PendingDispatch|\Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Fluent
     */
    public static function dispatchIf($boolean, ...$arguments)
    {
        return $boolean
            ? new PendingDispatch(new static(...$arguments))
            : new Fluent;
    }

    /**
     * Dispatch the job with the given arguments unless the given truth test passes.
     *
     * @param  bool  $boolean
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bus\PendingDispatch|\Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Fluent
     */
    public static function dispatchUnless($boolean, ...$arguments)
    {
        return ! $boolean
            ? new PendingDispatch(new static(...$arguments))
            : new Fluent;
    }

    /**
     * Dispatch a command to its appropriate handler in the current process.
     *
     * @return mixed
     */
    public static function dispatchNow()
    {
        return wp_app(Dispatcher::class)->dispatchNow(new static(...func_get_args()));
    }

    /**
     * Dispatch a command to its appropriate handler after the current process.
     *
     * @return mixed
     */
    public static function dispatchAfterResponse()
    {
        return wp_app(Dispatcher::class)->dispatchAfterResponse(new static(...func_get_args()));
    }

    /**
     * Set the jobs that should run if this job is successful.
     *
     * @param  array  $chain
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bus\PendingChain
     */
    public static function withChain($chain)
    {
        return new PendingChain(static::class, $chain);
    }
}
