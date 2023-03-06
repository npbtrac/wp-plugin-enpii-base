<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Log;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\ServiceProvider;

class LogServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('log', function ($app) {
            return new LogManager($app);
        });
    }
}
