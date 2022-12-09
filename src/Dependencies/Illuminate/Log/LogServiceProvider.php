<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Log;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\ServiceProvider;

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
