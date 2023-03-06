<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Broadcasting\Factory as BroadcastingFactoryContract;

/**
 * @method static \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Broadcasting\Broadcasters\Broadcaster channel(string $channel, callable|string  $callback, array $options = [])
 * @method static mixed auth(\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request $request)
 * @method static void connection($name = null);
 * @method static void routes(array $attributes = null)
 *
 * @see \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Broadcasting\Factory
 */
class Broadcast extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BroadcastingFactoryContract::class;
    }
}
