<?php

namespace Enpii_Base\Deps\Illuminate\Events;

use Enpii_Base\Deps\Illuminate\Contracts\Queue\Factory as QueueFactoryContract;
use Enpii_Base\Deps\Illuminate\Support\ServiceProvider;

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
