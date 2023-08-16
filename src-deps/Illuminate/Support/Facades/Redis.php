<?php

namespace Enpii_Base\Deps\Illuminate\Support\Facades;

/**
 * @method static \Enpii_Base\Deps\Illuminate\Redis\Connections\Connection connection(string $name = null)
 * @method static \Enpii_Base\Deps\Illuminate\Redis\Limiters\ConcurrencyLimiterBuilder funnel(string $name)
 * @method static \Enpii_Base\Deps\Illuminate\Redis\Limiters\DurationLimiterBuilder throttle(string $name)
 *
 * @see \Enpii_Base\Deps\Illuminate\Redis\RedisManager
 * @see \Enpii_Base\Deps\Illuminate\Contracts\Redis\Factory
 */
class Redis extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'redis';
    }
}
