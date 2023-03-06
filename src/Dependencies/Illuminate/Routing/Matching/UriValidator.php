<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Matching;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route;

class UriValidator implements ValidatorInterface
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
        $path = rtrim($request->getPathInfo(), '/') ?: '/';

        return preg_match($route->getCompiled()->getRegex(), rawurldecode($path));
    }
}
