<?php

declare(strict_types=1);

namespace Enpii_Base\Foundation\Bus;

use Enpii_Base\Deps\Illuminate\Contracts\Bus\Dispatcher;
use Enpii_Base\Deps\Illuminate\Foundation\Bus\PendingChain;
use Enpii_Base\Deps\Illuminate\Foundation\Bus\PendingDispatch;
use Enpii_Base\Deps\Illuminate\Support\Fluent;

trait Dispatchable_Trait
{
    /**
     * Dispatch the job with the given arguments.
     *
     * @return \Enpii_Base\Deps\Illuminate\Foundation\Bus\PendingDispatch
     */
    public static function dispatch()
    {
        return new PendingDispatch(new static(...func_get_args()));
    }

    /**
     * Dispatch the job with the given arguments if the given truth test passes.
     *
     * @param  bool  $boolean
     * @return \Enpii_Base\Deps\Illuminate\Foundation\Bus\PendingDispatch|\Enpii_Base\Deps\Illuminate\Support\Fluent
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
     * @return \Enpii_Base\Deps\Illuminate\Foundation\Bus\PendingDispatch|\Enpii_Base\Deps\Illuminate\Support\Fluent
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
     * @return \Enpii_Base\Deps\Illuminate\Foundation\Bus\PendingChain
     */
    public static function withChain($chain)
    {
        return new PendingChain(static::class, $chain);
    }

	/**
     * Dispatch a command to its appropriate handler in the current process.
	 * 	We use the name dispatchSync to match future updates of Laravel
     *
     * @return mixed
     */
    public static function dispatchSync()
    {
        return wp_app(Dispatcher::class)->dispatchNow(new static(...func_get_args()));
    }
}
