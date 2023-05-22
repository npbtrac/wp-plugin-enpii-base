<?php

namespace Enpii_Base\Deps\Illuminate\Routing\Middleware;

use Closure;
use Enpii_Base\Deps\Illuminate\Routing\Exceptions\InvalidSignatureException;

class ValidateSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Enpii_Base\Deps\Illuminate\Http\Response
     *
     * @throws \Enpii_Base\Deps\Illuminate\Routing\Exceptions\InvalidSignatureException
     */
    public function handle($request, Closure $next)
    {
        if ($request->hasValidSignature()) {
            return $next($request);
        }

        throw new InvalidSignatureException;
    }
}
