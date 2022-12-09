<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Middleware;

use Closure;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Exceptions\InvalidSignatureException;

class ValidateSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Response
     *
     * @throws \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Exceptions\InvalidSignatureException
     */
    public function handle($request, Closure $next)
    {
        if ($request->hasValidSignature()) {
            return $next($request);
        }

        throw new InvalidSignatureException;
    }
}
