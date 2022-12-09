<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Bus;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Bus\Dispatcher as DispatcherContract;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Bus\QueueingDispatcher as QueueingDispatcherContract;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Queue\Factory as QueueFactoryContract;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Support\DeferrableProvider;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\ServiceProvider;

class BusServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Dispatcher::class, function ($app) {
            return new Dispatcher($app, function ($connection = null) use ($app) {
                return $app[QueueFactoryContract::class]->connection($connection);
            });
        });

        $this->app->alias(
            Dispatcher::class, DispatcherContract::class
        );

        $this->app->alias(
            Dispatcher::class, QueueingDispatcherContract::class
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
            Dispatcher::class,
            DispatcherContract::class,
            QueueingDispatcherContract::class,
        ];
    }
}
