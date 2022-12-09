<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Providers;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Support\DeferrableProvider;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Composer;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('composer', function ($app) {
            return new Composer($app['files'], $app->basePath());
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['composer'];
    }
}
