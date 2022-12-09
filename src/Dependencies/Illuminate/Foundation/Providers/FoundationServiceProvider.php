<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Providers;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\AggregateServiceProvider;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades\URL;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Validation\ValidationException;

class FoundationServiceProvider extends AggregateServiceProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        FormRequestServiceProvider::class,
    ];

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../Exceptions/views' => $this->app->resourcePath('views/errors/'),
            ], 'laravel-errors');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->registerRequestValidation();
        $this->registerRequestSignatureValidation();
    }

    /**
     * Register the "validate" macro on the request.
     *
     * @return void
     *
     * @throws \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Validation\ValidationException
     */
    public function registerRequestValidation()
    {
        Request::macro('validate', function (array $rules, ...$params) {
            return wp_app_validator()->validate($this->all(), $rules, ...$params);
        });

        Request::macro('validateWithBag', function (string $errorBag, array $rules, ...$params) {
            try {
                return $this->validate($rules, ...$params);
            } catch (ValidationException $e) {
                $e->errorBag = $errorBag;

                throw $e;
            }
        });
    }

    /**
     * Register the "hasValidSignature" macro on the request.
     *
     * @return void
     */
    public function registerRequestSignatureValidation()
    {
        Request::macro('hasValidSignature', function ($absolute = true) {
            return URL::hasValidSignature($this, $absolute);
        });
    }
}
