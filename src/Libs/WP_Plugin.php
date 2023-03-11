<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Libs;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\ServiceProvider;
use Enpii\WP_Plugin\Enpii_Base\Libs\Interfaces\WP_Plugin_Interface;
use Enpii\WP_Plugin\Enpii_Base\Support\Traits\Config_Trait;
use InvalidArgumentException;

/**
 * This is the base class for plugin to be inherited from
 * We consider each plugin a Laravel Service provider
 * @package Enpii\WP_Plugin\Enpii_Base\Libs
 * @property \Enpii\WP_Plugin\Enpii_Base\Libs\WP_Application $app
 */
abstract class WP_Plugin extends ServiceProvider implements WP_Plugin_Interface {
	use Config_Trait;

	public const PARAM_KEY_PLUGIN_BASE_PATH = 'base_path';
	public const PARAM_KEY_PLUGIN_BASE_URL = 'base_url';

	protected $base_path;
	protected $base_url;

	/**
	 * We want to bind the the base params using an array
	 *
	 * @param array $base_params_arr
	 * @return void
	 * @throws InvalidArgumentException
	 */
	public function bind_base_params(array $base_params_arr): void {
		$this->bind_config($base_params_arr, true);
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
