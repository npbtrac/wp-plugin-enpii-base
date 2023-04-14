<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\WP;

use Enpii\WP_Plugin\Enpii_Base\App\Commands\Generic_WP_App_Command;
use Enpii\WP_Plugin\Enpii_Base\App\Queries\Generic_WP_App_Query;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Config\Repository;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Application;
use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Base_Command_Handler;
use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Base_Query_Handler;
use Enpii\WP_Plugin\Enpii_Base\Foundation\WP\WP_Plugin_Interface;
use Enpii\WP_Plugin\Enpii_Base\Foundation\WP\WP_Theme_Interface;
use InvalidArgumentException;
use TypeError;

/**
 * @package Enpii\WP_Plugin\Enpii_Base\App\WP
 */
class WP_Application extends Application {

	/**
     * We override the parent instance for not messing up with other application
     *
     * @var static
     */
    protected static $instance;

	/**
	 * We want to use the array to load the config
	 *
	 * @param mixed $config
	 * @return WP_Application
	 * @throws TypeError
	 * @throws \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Container\BindingResolutionException
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

	public function register_plugin(
		$plugin_classsname,
		$plugin_slug,
		$plugin_base_path,
		$plugin_base_url
	): void {
		$plugin = new $plugin_classsname( $this );
		if ( ! ( $plugin instanceof WP_Plugin_Interface ) ) {
			throw new InvalidArgumentException( sprintf( 'The target classname %s must implement %s', $plugin_classsname, WP_Plugin_Interface::class ) );
		}

		/** @var \Enpii\WP_Plugin\Enpii_Base\Foundation\WP\WP_Plugin $plugin  */
		$plugin->bind_base_params(
			[
				WP_Plugin_Interface::PARAM_KEY_PLUGIN_SLUG => $plugin_slug,
				WP_Plugin_Interface::PARAM_KEY_PLUGIN_BASE_PATH => $plugin_base_path,
				WP_Plugin_Interface::PARAM_KEY_PLUGIN_BASE_URL  => $plugin_base_url,
			]
		);
		$this->instance( $plugin_classsname, $plugin );
		$this->register( $plugin );
	}

	public function register_theme(
		$theme_classsname,
		$theme_base_path,
		$theme_base_url,
		$child_theme_base_path = null,
		$child_theme_base_url = null
	): void {
		$theme = new $theme_classsname( $this );
		if ( ! ( $theme instanceof WP_Theme_Interface ) ) {
			throw new InvalidArgumentException( sprintf( 'The target classname %s must implement %s', $theme_classsname, WP_Theme_Interface::class ) );
		}

		/** @var \Enpii\WP_Plugin\Enpii_Base\Libs\WP_Theme $theme  */
		$theme->bind_base_params(
			[
				WP_Theme_Interface::PARAM_KEY_THEME_BASE_PATH => $theme_base_path,
				WP_Theme_Interface::PARAM_KEY_THEME_BASE_URL  => $theme_base_url,
				WP_Theme_Interface::PARAM_KEY_CHILD_THEME_BASE_PATH  => $child_theme_base_path,
				WP_Theme_Interface::PARAM_KEY_CHILD_THEME_BASE_URL  => $child_theme_base_url,
			]
		);
		$this->instance( $theme_classsname, $theme );
		$this->register( $theme );
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

	public function execute_command_handler( string $handler_classname, $command = null ): void {
		$handler = $this->make($handler_classname);
		if ( ! ( $handler instanceof Base_Command_Handler ) ) {
			throw new InvalidArgumentException( sprintf( 'The target classname %s must implement %s', $handler_classname, Base_Command_Handler::class ) );
		}

		if ( empty( $command ) ) {
			$command = $this->make(Generic_WP_App_Command::class, [
				'wp_app' => $this,
			]);
		}

		$handler->handle( $command );
	}

	public function execute_query_handler( string $handler_classname, $command = null ): mixed {
		$handler = $this->make($handler_classname);
		if ( ! ( $handler instanceof Base_Query_Handler ) ) {
			throw new InvalidArgumentException( sprintf( 'The target classname %s must implement %s', $handler_classname, Base_Query_Handler::class ) );
		}

		if ( empty( $command ) ) {
			$command = new Generic_WP_App_Query( $this );
		}

		return $handler->handle( $command );
	}
}
