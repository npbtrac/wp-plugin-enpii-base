<?php


namespace Enpii\Wp\EnpiiBase\ServiceProviders;


use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class BaseServiceProvider extends ServiceProvider {
	public function register()
	{
		$services = config('services');

		if (is_array($services)) {
			foreach ($services as $serviceKey => $serviceConfig) {
				$this->app->singleton( $serviceKey, function ( $app ) use ( $serviceKey, $serviceConfig ) {
					return new $serviceKey( $serviceConfig );
				} );
			}
		}
	}
}