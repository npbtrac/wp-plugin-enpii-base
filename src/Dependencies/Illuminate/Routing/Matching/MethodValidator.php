<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Matching;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route;

class MethodValidator implements ValidatorInterface
{
    /**
     * Validate a given rule against a route and request.
     *
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route  $route
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @return bool
     */
    public function matches(Route $route, Request $request)
    {
        return in_array($request->getMethod(), $route->methods());
    }
}
