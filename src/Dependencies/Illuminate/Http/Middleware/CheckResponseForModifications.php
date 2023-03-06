<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Middleware;

use Closure;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response;

class CheckResponseForModifications
{
    /**
     * Handle an incoming request.
     *
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof Response) {
            $response->isNotModified($request);
        }

        return $response;
    }
}
