<?php

declare(strict_types=1);

namespace Enpii_Base\App\Http\Middleware;

use Enpii_Base\App\Models\User;
use Enpii_Base\App\Support\General_Helper;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Str;
use Random\RandomException;
use RuntimeException;

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
			$method = 'guard_' . Str::slug( str_replace( '-', ' ', $guard ), '_' );
			if (
				method_exists( $this, $method ) &&
				$this->auth->guard( $guard ) instanceof StatefulGuard
			) {
				$this->$method( $this->auth->guard( $guard ) );
			}

			if ( $this->auth->guard( $guard )->check() ) {
				return $this->auth->shouldUse( $guard );
			}
		}

		$this->unauthenticated( $request, $guards );
	}

	/**
	 * Extra actions for guard 'web'. We log WP logged in user to Laravel User
	 * @param StatefulGuard $stateful_guard
	 * @return void
	 * @throws RandomException
	 * @throws RuntimeException
	 */
	protected function guard_web( StatefulGuard $stateful_guard ) {
		/** @var \WP_User $user */
		$user_id = get_current_user_id();
		/** @var \Illuminate\Auth\SessionGuard $stateful_guard */
		$stateful_guard->login( User::find( $user_id ) );
	}

	/**
	 * Extra actions for guard 'web-is-administrator'.
	 *  User must be WP Administrator to be able to login
	 * @param StatefulGuard $stateful_guard
	 * @return void
	 * @throws RandomException
	 * @throws RuntimeException
	 */
	protected function guard_web_is_administrator( StatefulGuard $stateful_guard ) {
		if ( ! current_user_can( 'update_plugins' ) ) {
			return;
		}

		/** @var \WP_User $user */
		$user_id = get_current_user_id();
		/** @var \Illuminate\Auth\SessionGuard $stateful_guard */
		$stateful_guard->login( User::find( $user_id ) );
	}
}
