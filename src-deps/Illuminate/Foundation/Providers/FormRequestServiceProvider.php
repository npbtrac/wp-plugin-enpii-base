<?php

namespace Enpii_Base\Deps\Illuminate\Foundation\Providers;

use Enpii_Base\Deps\Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Enpii_Base\Deps\Illuminate\Foundation\Http\FormRequest;
use Enpii_Base\Deps\Illuminate\Routing\Redirector;
use Enpii_Base\Deps\Illuminate\Support\ServiceProvider;

class FormRequestServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->afterResolving(ValidatesWhenResolved::class, function ($resolved) {
            $resolved->validateResolved();
        });

        $this->app->resolving(FormRequest::class, function ($request, $app) {
            $request = FormRequest::createFrom($app['request'], $request);

            $request->setContainer($app)->setRedirector($app->make(Redirector::class));
        });
    }
}
