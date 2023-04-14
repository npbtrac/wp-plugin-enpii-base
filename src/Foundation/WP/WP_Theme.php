<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Foundation\WP;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\ServiceProvider;
use Enpii\WP_Plugin\Enpii_Base\Libs\Interfaces\Command_Interface;
use Enpii\WP_Plugin\Enpii_Base\Libs\Interfaces\Handler_Inferface;
use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Traits\Config_Trait;
use InvalidArgumentException;

/**
 * This is the base class for plugin to be inherited from
 * We consider each plugin a Laravel Service provider
 * @package Enpii\WP_Plugin\Enpii_Base\Libs
 * @property \Enpii\WP_Plugin\Enpii_Base\Libs\WP_Application $app
 */
abstract class WP_Theme extends ServiceProvider implements WP_Theme_Interface {
	use Config_Trait;

	protected $base_path;
	protected $base_url;
	protected $child_base_path;
	protected $child_base_url;

	/**
	 * We want to bind the the base params using an array
	 *
	 * @param array $base_params_arr
	 * @return void
	 * @throws InvalidArgumentException
	 */
	public function bind_base_params( array $base_params_arr ): void {
		$this->bind_config( $base_params_arr, true );
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		// We want to handle the hooks first
		$this->manipulate_hooks();

		$this->app->instance( __CLASS__, $this );
	}

	public function execute_generic_handler( string $handler_classname, Command_Interface $command = null ): void {
		$handler = new $handler_classname();
		if ( ! ( $handler instanceof Handler_Inferface ) ) {
			throw new InvalidArgumentException( sprintf( 'The target classname %s must implement %s', $handler_classname, Handler_Inferface::class ) );
		}

		if ( empty( $command ) ) {
			$command = new Generic_Command( $this->app );
		}

		$handler->handle( $command );
	}

	/**
	 * We want to get the views for each plugin by this order: child theme, parent theme, and the plugin it self
	 */
	protected function prepare_views_paths( $namespace ): void {
		$this->loadViewsFrom( realpath( get_stylesheet_directory() . DIR_SEP . 'views' ), $namespace );
		$this->loadViewsFrom( realpath( get_template_directory() . DIR_SEP . 'views' ), $namespace );
		$this->loadViewsFrom( realpath( dirname( __DIR__ ) . '/../resources/views' ), $namespace );
	}
}
