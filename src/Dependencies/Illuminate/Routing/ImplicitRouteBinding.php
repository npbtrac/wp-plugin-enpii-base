<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Routing\UrlRoutable;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Eloquent\ModelNotFoundException;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Reflector;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Str;

class ImplicitRouteBinding
{
    /**
     * Resolve the implicit route bindings for the given route.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Container\Container  $container
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Route  $route
     * @return void
     *
     * @throws \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function resolveForRoute($container, $route)
    {
        $parameters = $route->parameters();

        foreach ($route->signatureParameters(UrlRoutable::class) as $parameter) {
            if (! $parameterName = static::getParameterName($parameter->getName(), $parameters)) {
                continue;
            }

            $parameterValue = $parameters[$parameterName];

            if ($parameterValue instanceof UrlRoutable) {
                continue;
            }

            $instance = $container->make(Reflector::getParameterClassName($parameter));

            $parent = $route->parentOfParameter($parameterName);

            if ($parent instanceof UrlRoutable && in_array($parameterName, array_keys($route->bindingFields()))) {
                if (! $model = $parent->resolveChildRouteBinding(
                    $parameterName, $parameterValue, $route->bindingFieldFor($parameterName)
                )) {
                    throw (new ModelNotFoundException)->setModel(get_class($instance), [$parameterValue]);
                }
            } elseif (! $model = $instance->resolveRouteBinding($parameterValue, $route->bindingFieldFor($parameterName))) {
                throw (new ModelNotFoundException)->setModel(get_class($instance), [$parameterValue]);
            }

            $route->setParameter($parameterName, $model);
        }
    }

    /**
     * Return the parameter name if it exists in the given parameters.
     *
     * @param  string  $name
     * @param  array  $parameters
     * @return string|null
     */
    protected static function getParameterName($name, $parameters)
    {
        if (array_key_exists($name, $parameters)) {
            return $name;
        }

        if (array_key_exists($snakedName = Str::snake($name), $parameters)) {
            return $snakedName;
        }
    }
}
