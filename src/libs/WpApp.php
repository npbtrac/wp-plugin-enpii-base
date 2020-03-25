<?php


namespace Enpii\Wp\EnpiiBase\Libs;

use Enpii\Wp\EnpiiBase\Libs\Traits\ComponentTrait;
use Illuminate\Container\Container;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Mix;
use Illuminate\Foundation\PackageManifest;
use Illuminate\Log\LogServiceProvider;
use Illuminate\Routing\RoutingServiceProvider;

class WpApp extends Application {
	use ComponentTrait;

	protected static $_instance = null;

	/**
	 * WpApp constructor.
	 *
	 * @param null|string $base_path
	 */
	public function __construct( $base_path = null ) {
		parent::__construct( $base_path );
	}

	public function init( $config = null ) {
		$this->init_config( $config );
		static::setInstance( $this );
	}

	/**
	 * Register the basic bindings into the container.
	 * Override parent class to do nothing.
	 *
	 * @return void
	 */
	protected function registerBaseBindings() {
		static::setInstance( $this );

		$this->instance( 'app', $this );

	}

	/**
	 * Register all of the base service providers.
	 * Override parent class to do nothing.
	 *
	 * @return void
	 */
	protected function registerBaseServiceProviders() {
	}

	/**
	 * Register the core class aliases in the container.
	 * Override parent class to do nothing.
	 *
	 * @return void
	 */
	public function registerCoreContainerAliases() {
	}
}