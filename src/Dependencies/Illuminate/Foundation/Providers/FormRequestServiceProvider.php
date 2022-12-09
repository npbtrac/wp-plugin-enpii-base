<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Providers;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Http\FormRequest;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Redirector;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\ServiceProvider;

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
