<?php

namespace Enpii_Base\Deps\Illuminate\Routing\Matching;

use Enpii_Base\Deps\Illuminate\Http\Request;
use Enpii_Base\Deps\Illuminate\Routing\Route;

class MethodValidator implements ValidatorInterface
{
    /**
     * Validate a given rule against a route and request.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Routing\Route  $route
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @return bool
     */
    public function matches(Route $route, Request $request)
    {
        return in_array($request->getMethod(), $route->methods());
    }
}
