<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades;

/**
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Redis\Connections\Connection connection(string $name = null)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Redis\Limiters\ConcurrencyLimiterBuilder funnel(string $name)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Redis\Limiters\DurationLimiterBuilder throttle(string $name)
 *
 * @see \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Redis\RedisManager
 * @see \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Redis\Factory
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
