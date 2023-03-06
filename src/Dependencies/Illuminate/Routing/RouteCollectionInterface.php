<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Routing;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request;

interface RouteCollectionInterface
{
    /**
     * Add a Route instance to the collection.
     *
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route  $route
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route
     */
    public function add(Route $route);

    /**
     * Refresh the name look-up table.
     *
     * This is done in case any names are fluently defined or if routes are overwritten.
     *
     * @return void
     */
    public function refreshNameLookups();

    /**
     * Refresh the action look-up table.
     *
     * This is done in case any actions are overwritten with new controllers.
     *
     * @return void
     */
    public function refreshActionLookups();

    /**
     * Find the first route matching a given request.
     *
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route
     *
     * @throws \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException
     * @throws \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function match(Request $request);

    /**
     * Get routes from the collection by method.
     *
     * @param  string|null  $method
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route[]
     */
    public function get($method = null);

    /**
     * Determine if the route collection contains a given named route.
     *
     * @param  string  $name
     * @return bool
     */
    public function hasNamedRoute($name);

    /**
     * Get a route instance by its name.
     *
     * @param  string  $name
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route|null
     */
    public function getByName($name);

    /**
     * Get a route instance by its controller action.
     *
     * @param  string  $action
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route|null
     */
    public function getByAction($action);

    /**
     * Get all of the routes in the collection.
     *
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route[]
     */
    public function getRoutes();

    /**
     * Get all of the routes keyed by their HTTP verb / method.
     *
     * @return array
     */
    public function getRoutesByMethod();

    /**
     * Get all of the routes keyed by their name.
     *
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route[]
     */
    public function getRoutesByName();
}
