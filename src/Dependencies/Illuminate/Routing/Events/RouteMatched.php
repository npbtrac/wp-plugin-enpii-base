<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Events;

class RouteMatched
{
    /**
     * The route instance.
     *
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route
     */
    public $route;

    /**
     * The request instance.
     *
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route  $route
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct($route, $request)
    {
        $this->route = $route;
        $this->request = $request;
    }
}
