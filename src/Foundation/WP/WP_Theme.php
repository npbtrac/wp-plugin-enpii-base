<?php

declare(strict_types=1);

namespace Enpii_Base\Foundation\WP;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\ServiceProvider;
use Enpii_Base\Foundation\Shared\Traits\Config_Trait;
use Enpii_Base\Foundation\Shared\Traits\Accessor_Set_Get_Has_Trait;
use InvalidArgumentException;

/**
 * This is the base class for plugin to be inherited from
 * We consider each plugin a Laravel Service provider
 * @package Enpii_Base\Libs
 * @property \Enpii_Base\App\WP\WP_Application $app
 */
abstract class WP_Theme extends ServiceProvider implements WP_Theme_Interface {
	use Config_Trait;
	use Accessor_Set_Get_Has_Trait;

	protected $base_path;
	protected $base_url;
	protected $parent_base_path;
	protected $parent_base_url;

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

	/**
	 * We want to get the views for each plugin by this order: child theme, parent theme, and the plugin it self
	 */
	protected function prepare_views_paths( $namespace ): void {
		$this->loadViewsFrom( realpath( $this->get_base_path() ), $namespace );
		if ( ! empty( $this->get_parent_base_path() ) ) {
			$this->loadViewsFrom( realpath( $this->get_parent_base_path() ), $namespace );
		}
	}
}
