<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades;

/**
 * @method static \Enpii\WP_Plugin\Enpii_Base\Dependencies\Psr\Log\LoggerInterface channel(string $channel = null)
 * @method static \Enpii\WP_Plugin\Enpii_Base\Dependencies\Psr\Log\LoggerInterface stack(array $channels, string $channel = null)
 * @method static void alert(string $message, array $context = [])
 * @method static void critical(string $message, array $context = [])
 * @method static void debug(string $message, array $context = [])
 * @method static void emergency(string $message, array $context = [])
 * @method static void error(string $message, array $context = [])
 * @method static void info(string $message, array $context = [])
 * @method static void log($level, string $message, array $context = [])
 * @method static void notice(string $message, array $context = [])
 * @method static void warning(string $message, array $context = [])
 *
 * @see \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Log\Logger
 */
class Log extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'log';
    }
}
