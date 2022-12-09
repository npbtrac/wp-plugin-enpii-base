<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Contracts;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route;

interface ControllerDispatcher
{
    /**
     * Dispatch a request to a given controller and method.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route  $route
     * @param  mixed  $controller
     * @param  string  $method
     * @return mixed
     */
    public function dispatch(Route $route, $controller, $method);

    /**
     * Get the middleware for the controller instance.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Controller  $controller
     * @param  string  $method
     * @return array
     */
    public function getMiddleware($controller, $method);
}
