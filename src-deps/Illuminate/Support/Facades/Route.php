<?php

namespace Enpii_Base\Deps\Illuminate\Support\Facades;

/**
 * @method static \Enpii_Base\Deps\Illuminate\Routing\PendingResourceRegistration apiResource(string $name, string $controller, array $options = [])
 * @method static \Enpii_Base\Deps\Illuminate\Routing\PendingResourceRegistration resource(string $name, string $controller, array $options = [])
 * @method static \Enpii_Base\Deps\Illuminate\Routing\Route any(string $uri, array|string|callable|null $action = null)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\Route current()
 * @method static \Enpii_Base\Deps\Illuminate\Routing\Route delete(string $uri, array|string|callable|null $action = null)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\Route fallback(array|string|callable|null $action = null)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\Route get(string $uri, array|string|callable|null $action = null)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\Route getCurrentRoute()
 * @method static \Enpii_Base\Deps\Illuminate\Routing\Route match(array|string $methods, string $uri, array|string|callable|null $action = null)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\Route options(string $uri, array|string|callable|null $action = null)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\Route patch(string $uri, array|string|callable|null $action = null)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\Route permanentRedirect(string $uri, string $destination)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\Route post(string $uri, array|string|callable|null $action = null)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\Route put(string $uri, array|string|callable|null $action = null)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\Route redirect(string $uri, string $destination, int $status = 302)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\Route substituteBindings(\Enpii_Base\Deps\Illuminate\Support\Facades\Route $route)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\Route view(string $uri, string $view, array $data = [])
 * @method static \Enpii_Base\Deps\Illuminate\Routing\RouteRegistrar as(string $value)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\RouteRegistrar domain(string $value)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\RouteRegistrar middleware(array|string|null $middleware)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\RouteRegistrar name(string $value)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\RouteRegistrar namespace(string $value)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\RouteRegistrar prefix(string  $prefix)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\RouteRegistrar where(array  $where)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\Router|\Enpii_Base\Deps\Illuminate\Routing\RouteRegistrar group(\Closure|string|array $attributes, \Closure|string $routes)
 * @method static string|null currentRouteAction()
 * @method static string|null currentRouteName()
 * @method static void apiResources(array $resources, array $options = [])
 * @method static void bind(string $key, string|callable $binder)
 * @method static void model(string $key, string $class, \Closure|null $callback = null)
 * @method static void pattern(string $key, string $pattern)
 * @method static void resources(array $resources)
 * @method static void substituteImplicitBindings(\Enpii_Base\Deps\Illuminate\Support\Facades\Route $route)
 *
 * @see \Enpii_Base\Deps\Illuminate\Routing\Router
 */
class Route extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'router';
    }
}
