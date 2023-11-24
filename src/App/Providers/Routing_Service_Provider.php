<?php

declare(strict_types=1);

namespace Enpii_Base\App\Providers;

use Enpii_Base\App\Routing\Response_Factory;
use Illuminate\Contracts\Routing\ResponseFactory as ResponseFactoryContract;
use Illuminate\Contracts\View\Factory as ViewFactoryContract;
use Illuminate\Routing\RoutingServiceProvider;

class Routing_Service_Provider extends RoutingServiceProvider {
	/**
     * Register the response factory implementation.
     *
     * @return void
     */
    protected function registerResponseFactory()
    {
		$this->app->singleton(ResponseFactoryContract::class, function ($app) {
            return new Response_Factory($app[ViewFactoryContract::class], $app['redirect']);
        });
    }
}
