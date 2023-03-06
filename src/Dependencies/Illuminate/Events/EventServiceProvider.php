<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Events;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Queue\Factory as QueueFactoryContract;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('events', function ($app) {
            return (new Dispatcher($app))->setQueueResolver(function () use ($app) {
                return $app->make(QueueFactoryContract::class);
            });
        });
    }
}
