<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Matching;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route;

class MethodValidator implements ValidatorInterface
{
    /**
     * Validate a given rule against a route and request.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route  $route
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @return bool
     */
    public function matches(Route $route, Request $request)
    {
        return in_array($request->getMethod(), $route->methods());
    }
}
