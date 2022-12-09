<?php

declare(strict_types=1);

namespace Enpii\Wp_Plugin\Enpii_Base\Libs;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\ServiceProvider;
use Enpii\Wp_Plugin\Enpii_Base\Libs\Interfaces\Wp_Plugin_Interface;

/**
 * This is the base class for plugin to be inherited from
 * We consider each plugin a Laravel Service provider
 * @package Enpii\Wp_Plugin\Enpii_Base\Libs
 * @property \Enpii\Wp_Plugin\Enpii_Base\Libs\Wp_Application $app
 */
abstract class Wp_Plugin extends ServiceProvider implements Wp_Plugin_Interface {
	protected $base_path;
	protected $base_url;

	/**
	 * We want to get the views for each plugin by this order: child theme, parent theme, and the plugin it self
	 */
	protected function prepare_views_paths( $namespace ): void {
		$this->loadViewsFrom( realpath( get_stylesheet_directory() . DIR_SEP . 'views' ), $namespace );
		$this->loadViewsFrom( realpath( get_template_directory() . DIR_SEP . 'views' ), $namespace );
		$this->loadViewsFrom( realpath( dirname( __DIR__ ) . '/../resources/views' ), $namespace );
	}
}
