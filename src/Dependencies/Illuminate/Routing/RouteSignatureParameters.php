<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Reflector;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Str;
use ReflectionFunction;
use ReflectionMethod;

class RouteSignatureParameters
{
    /**
     * Extract the route action's signature parameters.
     *
     * @param  array  $action
     * @param  string|null  $subClass
     * @return array
     */
    public static function fromAction(array $action, $subClass = null)
    {
        $parameters = is_string($action['uses'])
                        ? static::fromClassMethodString($action['uses'])
                        : (new ReflectionFunction($action['uses']))->getParameters();

        return is_null($subClass) ? $parameters : array_filter($parameters, function ($p) use ($subClass) {
            return Reflector::isParameterSubclassOf($p, $subClass);
        });
    }

    /**
     * Get the parameters for the given class / method by string.
     *
     * @param  string  $uses
     * @return array
     */
    protected static function fromClassMethodString($uses)
    {
        [$class, $method] = Str::parseCallback($uses);

        if (! method_exists($class, $method) && Reflector::isCallable($class, $method)) {
            return [];
        }

        return (new ReflectionMethod($class, $method))->getParameters();
    }
}
