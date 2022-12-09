<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades;

/**
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\View\Factory addNamespace(string $namespace, string|array $hints)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\View\Factory first(array $views, \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Support\Arrayable|array $data, array $mergeData)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\View\Factory replaceNamespace(string $namespace, string|array $hints)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\View\View file(string $path, array $data = [], array $mergeData = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\View\View make(string $view, array $data = [], array $mergeData = [])
 * @method static array composer(array|string $views, \Closure|string $callback)
 * @method static array creator(array|string $views, \Closure|string $callback)
 * @method static bool exists(string $view)
 * @method static mixed share(array|string $key, $value = null)
 *
 * @see \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\View\Factory
 */
class View extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'view';
    }
}
