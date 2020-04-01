<?php


namespace Enpii\Wp\EnpiiBase\App\Providers;


use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class WordPressServiceProvider extends ServiceProvider {
	public function register() {

		$this->registerAppSingletons();
//		$this->registerAppBindings();
	}

	protected function registerAppSingletons() {
		$singletons = config( 'singletons' );

		if ( is_array( $singletons ) ) {
			foreach ( $singletons as $singletonKey => $singletonConfig ) {
				$this->app->singleton( $singletonKey, function ( $app ) use ( $singletonKey, $singletonConfig ) {
					return new $singletonKey( $singletonConfig );
				} );
			}
		}
	}

	protected function registerAppBindings() {
		$bindings = config( 'bindings' );

		if ( is_array( $bindings ) ) {
			foreach ( $bindings as $bindingKey => $bindingConfig ) {
				$this->app->bind( $bindingKey, function ( $app ) use ( $bindingKey, $bindingConfig ) {
					return new $bindingKey( $bindingConfig );
				} );
			}
		}
	}
}