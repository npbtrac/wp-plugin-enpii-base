<?php

namespace Enpii_Base\App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WP_User_Session_Is_Admin_User_Validation {

	/**
	 * Perform if there's a logged in user in the current session
	 * @param Illuminate\Http\Request $request
	 * @param Closure $next
	 * @return Enpii_Base\DepsSymfony\Component\HttpFoundation\Response
	 * @throws BindingResolutionException
	 */
	public function handle( Request $request, Closure $next ): Response {
		// phpcs:ignore WordPress.WP.Capabilities.RoleFound
		if ( ! current_user_can( 'administrator' ) ) {
			wp_app_abort( 403, 'Access Denied' );
		}

		return $next( $request );
	}
}
