<?php

namespace Enpii_Base\Deps\Illuminate\Http\Middleware;

use Closure;
use Enpii_Base\Deps\Symfony\Component\HttpFoundation\Response;

class CheckResponseForModifications
{
    /**
     * Handle an incoming request.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
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
