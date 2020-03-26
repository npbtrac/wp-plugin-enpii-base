<?php


namespace Enpii\Wp\EnpiiBase\Libs;

use Enpii\Wp\EnpiiBase\Libs\Traits\ServiceTrait;
use Enpii\Wp\EnpiiBase\ServiceProviders\BaseServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Config\Repository as ConfigRepository;


class WpApp extends Application {
	use ServiceTrait;

	protected $config = null;

	/**
	 * WpApp constructor.
	 *
	 * @param null|string $base_path
	 */
	public function __construct( $base_path = null ) {
		parent::__construct( $base_path );
	}

	public function init_config( $config = null ) {
		$this->singleton( 'config', function ( $app ) use ( $config ) {
			return new ConfigRepository( $config );
		} );

		$this->registerKeyServiceProviders();
	}

	protected function registerKeyServiceProviders() {
		$this->register(new BaseServiceProvider($this));
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

//		$this->alias('config', \Illuminate\Config\Repository::class);
//		$this->alias('config', \Illuminate\Contracts\Config\Repository::class);
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