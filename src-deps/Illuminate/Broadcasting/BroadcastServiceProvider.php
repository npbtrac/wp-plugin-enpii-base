<?php

namespace Enpii_Base\Deps\Illuminate\Broadcasting;

use Enpii_Base\Deps\Illuminate\Contracts\Broadcasting\Broadcaster as BroadcasterContract;
use Enpii_Base\Deps\Illuminate\Contracts\Broadcasting\Factory as BroadcastingFactory;
use Enpii_Base\Deps\Illuminate\Contracts\Support\DeferrableProvider;
use Enpii_Base\Deps\Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BroadcastManager::class, function ($app) {
            return new BroadcastManager($app);
        });

        $this->app->singleton(BroadcasterContract::class, function ($app) {
            return $app->make(BroadcastManager::class)->connection();
        });

        $this->app->alias(
            BroadcastManager::class, BroadcastingFactory::class
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            BroadcastManager::class,
            BroadcastingFactory::class,
            BroadcasterContract::class,
        ];
    }
}
