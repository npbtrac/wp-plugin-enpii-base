<?php

namespace Enpii_Base\Deps\Illuminate\Routing\Matching;

use Enpii_Base\Deps\Illuminate\Http\Request;
use Enpii_Base\Deps\Illuminate\Routing\Route;

class UriValidator implements ValidatorInterface
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
        $path = rtrim($request->getPathInfo(), '/') ?: '/';

        return preg_match($route->getCompiled()->getRegex(), rawurldecode($path));
    }
}
