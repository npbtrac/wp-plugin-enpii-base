<?php

namespace Enpii_Base\Deps\Illuminate\Pipeline;

use Enpii_Base\Deps\Illuminate\Contracts\Pipeline\Hub as PipelineHubContract;
use Enpii_Base\Deps\Illuminate\Contracts\Support\DeferrableProvider;
use Enpii_Base\Deps\Illuminate\Support\ServiceProvider;

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
