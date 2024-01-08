<?php

declare(strict_types=1);

namespace Enpii_Base\App\Http\Middleware;

use Enpii_Base\App\Support\General_Helper;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware {

	/**
	 * Get the path the user should be redirected to when they are not authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return string|null
	 */
	protected function redirectTo( $request ) {
		return $request->expectsJson() ? null : wp_login_url( General_Helper::get_current_url() );
	}

	/**
	 * Determine if the user is logged in to any of the given guards.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  array  $guards
	 * @return void
	 *
	 * @throws \Illuminate\Auth\AuthenticationException
	 */
	// phpcs:ignore Generic.NamingConventions.ConstructorName.OldStyle
	protected function authenticate( $request, array $guards ) {
		if ( empty( $guards ) ) {
			$guards = [ null ];
		}

		foreach ( $guards as $guard ) {
			if ( $this->auth->guard( $guard )->check() ) {
				return $this->auth->shouldUse( $guard );
			}
		}

		$this->unauthenticated( $request, $guards );
	}
}
