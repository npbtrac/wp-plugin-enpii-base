<?php

declare(strict_types=1);

namespace Enpii\Wp_Plugin\Enpii_Base\Libs;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Config\Repository;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Application;
use TypeError;

class Wp_Application extends Application {

	/**
	 * We want to use the array to load the config
	 *
	 * @param mixed $config
	 * @return Wp_Application
	 * @throws TypeError
	 * @throws TypeError
	 * @throws TypeError
	 * @throws TypeError
	 * @throws TypeError
	 * @throws \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Container\BindingResolutionException
	 */
	public function init_config( $config = null ): self {
		$this->singleton(
			'config',
			function ( $app ) use ( $config ) {
				return new Repository( $config );
			}
		);

		return $this;
	}

	public function register_cache_service_provider(): void {
		$this->register( \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Cache\CacheServiceProvider::class );
	}

	/**
	 * Get the path to the resources directory.
	 *
	 * @param  string  $path
	 * @return string
	 */
	public function resourcePath( $path = '' ) {
		return dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . 'resources' . ( $path ? DIRECTORY_SEPARATOR . $path : $path );
	}

	public static function getInstance() {
		if ( is_null( static::$instance ) ) {
			static::$instance = new self();
		}

		return static::$instance;
	}
}
