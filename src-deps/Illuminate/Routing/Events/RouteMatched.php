<?php

namespace Enpii_Base\Deps\Illuminate\Routing\Events;

class RouteMatched
{
    /**
     * The route instance.
     *
     * @var \Enpii_Base\Deps\Illuminate\Routing\Route
     */
    public $route;

    /**
     * The request instance.
     *
     * @var \Enpii_Base\Deps\Illuminate\Http\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Routing\Route  $route
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct($route, $request)
    {
        $this->route = $route;
        $this->request = $request;
    }
}
