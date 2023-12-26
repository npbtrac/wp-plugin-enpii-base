<?php

declare(strict_types=1);

namespace Enpii_Base\Foundation\Bus;

use Closure;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Bus\PendingChain;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Support\Fluent;
use InvalidArgumentException;

trait Dispatchable_Trait {
	/**
	 * Dispatch the job with the given arguments.
	 * Inherited from Laravel Illuminate\Foundation\Bus\Dispatchable
	 *
	 * @param  mixed  ...$arguments
	 * @return \Illuminate\Foundation\Bus\PendingDispatch
	 */
	// phpcs:ignore WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid
	public static function dispatch( ...$arguments ) {
		return new PendingDispatch( new static( ...$arguments ) );
	}

	/**
	 * Dispatch the job with the given arguments if the given truth test passes.
	 * Inherited from Laravel Illuminate\Foundation\Bus\Dispatchable
	 *
	 * @param  bool|\Closure  $boolean
	 * @param  mixed  ...$arguments
	 * @return \Illuminate\Foundation\Bus\PendingDispatch|\Illuminate\Support\Fluent
	 */
	// phpcs:ignore WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid
	public static function dispatchIf( $boolean, ...$arguments ) {
		if ( $boolean instanceof Closure ) {
			$dispatchable = new static( ...$arguments );

			return value( $boolean, $dispatchable )
				? new PendingDispatch( $dispatchable )
				: new Fluent();
		}

		return value( $boolean )
			? new PendingDispatch( new static( ...$arguments ) )
			: new Fluent();
	}

	/**
	 * Dispatch the job with the given arguments unless the given truth test passes.
	 * Inherited from Laravel Illuminate\Foundation\Bus\Dispatchable
	 *
	 * @param  bool|\Closure  $boolean
	 * @param  mixed  ...$arguments
	 * @return \Illuminate\Foundation\Bus\PendingDispatch|\Illuminate\Support\Fluent
	 */
	// phpcs:ignore WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid
	public static function dispatchUnless( $boolean, ...$arguments ) {
		if ( $boolean instanceof Closure ) {
			$dispatchable = new static( ...$arguments );

			return ! value( $boolean, $dispatchable )
				? new PendingDispatch( $dispatchable )
				: new Fluent();
		}

		return ! value( $boolean )
			? new PendingDispatch( new static( ...$arguments ) )
			: new Fluent();
	}

	/**
	 * Dispatch a command to its appropriate handler in the current process.
	 * Inherited from Laravel Illuminate\Foundation\Bus\Dispatchable
	 *
	 * Queueable jobs will be dispatched to the "sync" queue.
	 *
	 * @param  mixed  ...$arguments
	 * @return mixed
	 */
	// phpcs:ignore WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid
	public static function dispatchSync( ...$arguments ) {
		return wp_app( Dispatcher::class )->dispatchSync( new static( ...$arguments ) );
	}

	/**
	 * Dispatch a command to its appropriate handler after the current process.
	 * Inherited from Laravel Illuminate\Foundation\Bus\Dispatchable
	 *
	 * @param  mixed  ...$arguments
	 * @return mixed
	 */
	// phpcs:ignore WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid
	public static function dispatchAfterResponse( ...$arguments ) {
		return self::dispatch( ...$arguments )->afterResponse();
	}

	/**
	 * Set the jobs that should run if this job is successful.
	 * Inherited from Laravel Illuminate\Foundation\Bus\Dispatchable
	 *
	 * @param  array  $chain
	 * @return \Illuminate\Foundation\Bus\PendingChain
	 */
	// phpcs:ignore WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid
	public static function withChain( $chain ) {
		return new PendingChain( static::class, $chain );
	}
}
