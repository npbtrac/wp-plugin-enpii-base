<?php

declare(strict_types=1);

namespace Enpii_Base\Foundation\WP;

use Enpii_Base\Deps\Illuminate\Support\ServiceProvider;
use Enpii_Base\Foundation\Shared\Traits\Accessor_Set_Get_Has_Trait;
use Enpii_Base\Foundation\Shared\Traits\Config_Trait;
use InvalidArgumentException;

/**
 * This is the base class for plugin to be inherited from
 * We consider each plugin a Laravel Service provider
 * @package \Enpii_Base\App\WP
 * @property \Enpii_Base\App\WP\WP_Application $app
 * @method get_plugin_slug() string	the slug name of the plugin (folder name)
 * @method get_base_path() string	the directory path of the plugin
 * @method get_base_url() string	the url to plugin directory
 */
abstract class WP_Plugin extends ServiceProvider implements WP_Plugin_Interface {
	use Config_Trait;
	use Accessor_Set_Get_Has_Trait;

	protected $plugin_slug;
	protected $base_path;
	protected $base_url;

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
		// We need to ensure all needed properties are set
		$this->validate_needed_properties();

		// We want to handle the hooks first
		$this->manipulate_hooks();
	}

	public function boot() {
		$this->prepare_views_paths( $this->get_plugin_slug() );
	}

	public function get_views_path() {
		$this->get_base_path() . DIR_SEP . 'resources' . DIR_SEP . 'views';
	}

	protected function validate_needed_properties(): void {
		foreach (['plugin_slug', 'base_path', 'base_url'] as $property) {
			if ( empty($this->$property) ) {
				throw new InvalidArgumentException(
					sprintf(
						'Property %s must be set for %s',
						$property,
						get_class($this)
					)
				);
			}
		}
	}

	/**
	 * We want to get the views for each plugin by this order: child theme, parent theme, and the plugin it self
	 */
	protected function prepare_views_paths( $namespace ): void {
		$this->loadViewsFrom(
			realpath(
				get_stylesheet_directory() . DIR_SEP . 'resources' . DIR_SEP . 'views'
				. DIR_SEP . '_plugins' . DIR_SEP . $namespace
			),
			$namespace
		);
		if ( get_template_directory() !== get_stylesheet_directory() ) {
			$this->loadViewsFrom(
				realpath(
					get_template_directory() . DIR_SEP . 'resources' . DIR_SEP . 'views'
					. DIR_SEP . '_plugins' . DIR_SEP . $namespace
				),
				$namespace
			);
		}
		$this->loadViewsFrom(
			realpath( $this->get_base_path() . DIR_SEP . 'resources' . DIR_SEP . 'views' ),
			$namespace
		);
	}
}
