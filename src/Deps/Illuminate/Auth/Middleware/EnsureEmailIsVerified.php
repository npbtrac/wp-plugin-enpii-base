<?php

namespace Enpii_Base\Deps\Illuminate\Auth\Middleware;

use Closure;
use Enpii_Base\Deps\Illuminate\Contracts\Auth\MustVerifyEmail;
use Enpii_Base\Deps\Illuminate\Support\Facades\Redirect;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Enpii_Base\Deps\Illuminate\Http\Response|\Enpii_Base\Deps\Illuminate\Http\RedirectResponse
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
