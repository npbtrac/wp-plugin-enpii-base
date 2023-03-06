<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Auth\Middleware;

use Closure;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\MustVerifyEmail;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades\Redirect;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Response|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if (! $request->user() ||
            ($request->user() instanceof MustVerifyEmail &&
            ! $request->user()->hasVerifiedEmail())) {
            return $request->expectsJson()
                    ? wp_app_abort(403, 'Your email address is not verified.')
                    : Redirect::route($redirectToRoute ?: 'verification.notice');
        }

        return $next($request);
    }
}
