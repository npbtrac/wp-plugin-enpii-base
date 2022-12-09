<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades;

/**
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\PendingResourceRegistration apiResource(string $name, string $controller, array $options = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\PendingResourceRegistration resource(string $name, string $controller, array $options = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route any(string $uri, array|string|callable|null $action = null)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route current()
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route delete(string $uri, array|string|callable|null $action = null)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route fallback(array|string|callable|null $action = null)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route get(string $uri, array|string|callable|null $action = null)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route getCurrentRoute()
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route match(array|string $methods, string $uri, array|string|callable|null $action = null)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route options(string $uri, array|string|callable|null $action = null)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route patch(string $uri, array|string|callable|null $action = null)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route permanentRedirect(string $uri, string $destination)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route post(string $uri, array|string|callable|null $action = null)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route put(string $uri, array|string|callable|null $action = null)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route redirect(string $uri, string $destination, int $status = 302)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route substituteBindings(\Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades\Route $route)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route view(string $uri, string $view, array $data = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\RouteRegistrar as(string $value)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\RouteRegistrar domain(string $value)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\RouteRegistrar middleware(array|string|null $middleware)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\RouteRegistrar name(string $value)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\RouteRegistrar namespace(string $value)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\RouteRegistrar prefix(string  $prefix)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\RouteRegistrar where(array  $where)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Router|\Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\RouteRegistrar group(\Closure|string|array $attributes, \Closure|string $routes)
 * @method static string|null currentRouteAction()
 * @method static string|null currentRouteName()
 * @method static void apiResources(array $resources, array $options = [])
 * @method static void bind(string $key, string|callable $binder)
 * @method static void model(string $key, string $class, \Closure|null $callback = null)
 * @method static void pattern(string $key, string $pattern)
 * @method static void resources(array $resources)
 * @method static void substituteImplicitBindings(\Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades\Route $route)
 *
 * @see \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Router
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
