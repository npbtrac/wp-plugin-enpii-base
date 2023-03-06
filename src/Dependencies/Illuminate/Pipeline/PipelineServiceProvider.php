<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Pipeline;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Pipeline\Hub as PipelineHubContract;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Support\DeferrableProvider;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\ServiceProvider;

class PipelineServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            PipelineHubContract::class, Hub::class
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
            PipelineHubContract::class,
        ];
    }
}
