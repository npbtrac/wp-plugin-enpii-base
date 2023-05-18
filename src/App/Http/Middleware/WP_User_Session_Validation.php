<?php

namespace Enpii\WP_Plugin\Enpii_Base\App\Http\Middleware;

use Closure;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Container\BindingResolutionException;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response;

class WP_User_Session_Validation
{
    /**
	  * Perform if there's a logged in user in the current session
	  * @param Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request $request
	  * @param Closure $next
	  * @return Enpii\WP_Plugin\Enpii_Base\DependenciesSymfony\Component\HttpFoundation\Response
	  * @throws BindingResolutionException
	  */
    public function handle(Request $request, Closure $next): Response
    {
		$wp_user = wp_get_current_user();
		if (empty($wp_user->ID)) {
			wp_app_abort(403, 'Access Denied');
		}

        return $next($request);
    }
}
