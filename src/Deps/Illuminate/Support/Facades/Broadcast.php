<?php

namespace Enpii_Base\Deps\Illuminate\Support\Facades;

use Enpii_Base\Deps\Illuminate\Contracts\Broadcasting\Factory as BroadcastingFactoryContract;

/**
 * @method static \Enpii_Base\Deps\Illuminate\Broadcasting\Broadcasters\Broadcaster channel(string $channel, callable|string  $callback, array $options = [])
 * @method static mixed auth(\Enpii_Base\Deps\Illuminate\Http\Request $request)
 * @method static void connection($name = null);
 * @method static void routes(array $attributes = null)
 *
 * @see \Enpii_Base\Deps\Illuminate\Contracts\Broadcasting\Factory
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
