<?php

declare(strict_types=1);

namespace Enpii\Wp_Plugin\Enpii_Base\Base;

use Enpii\Wp_Plugin\Enpii_Base\App\Http\Controllers\Index_Controller;
use Enpii\Wp_Plugin\Enpii_Base\App\Providers\Filesystem_Service_Provider;
use Enpii\Wp_Plugin\Enpii_Base\App\Providers\Log_Service_Provider;
use Enpii\Wp_Plugin\Enpii_Base\App\Providers\Route_Service_Provider;
use Enpii\Wp_Plugin\Enpii_Base\App\Providers\View_Service_Provider;
use Enpii\Wp_Plugin\Enpii_Base\Base\Hook_Handlers\Register_Main_Service_Providers_Hook_Handler;
use Enpii\Wp_Plugin\Enpii_Base\Base\Hook_Handlers\Wp_App_Hook_Handler;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades\Route;
use Enpii\Wp_Plugin\Enpii_Base\Libs\WP_Plugin;
use Enpii\Wp_Plugin\Enpii_Base\Support\Traits\Accessor_Set_Get_Has_Trait;

/**
 *
 * @package Enpii\Wp_Plugin\Enpii_Base\Base
 * @method get_base_bath() string, the directory path of the plugin
 * @method get_base_url() string, the url to plugin directory
 */
class Plugin extends WP_Plugin {
	use Accessor_Set_Get_Has_Trait;

	public function boot() {
		$this->prepare_views_paths( ENPII_BASE_PLUGIN_SLUG );
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

		// We want to register main providers here
		do_action( 'enpii_base_register_main_service_providers' );
	}

	public function manipulate_hooks(): void {
		// We want to start processing wp-app requests after all plugins and theme loaded
		add_action( 'init', [ $this, 'handle_wp_app_requests' ], 9999 );

		// WP app hooks
		add_action( 'enpii_base_wp_app_register_routes', [ $this, 'register_wp_app_routes' ] );

		// General hooks
		add_action( 'enpii_base_register_main_service_providers', [ $this, 'register_main_service_providers' ] );
	}

	public function register_main_service_providers(): void {
		/**
		| We want to register main Service Providers for the wp_app()
		| You can remove this handler to replace with the Service Providers you want
		 */
		if ( $this->is_wp_app_mode() ) {
			( new Register_Main_Service_Providers_Hook_Handler() )->handle();
		}
	}

	public function handle_wp_app_requests(): void {
		// We want to check that if the uri prefix is for wp-app before invoke the handler
		// to keep the handler lazy-loading
		if ( $this->is_wp_app_mode() ) {
			( new Wp_App_Hook_Handler() )->handle_wp_app_requests();
		}
	}

	public function register_wp_app_routes(): void {
		// We want to check that if the uri prefix is for wp-app before invoke the handler
		// to keep the handler lazy-loading
		if ( $this->is_wp_app_mode() ) {
			Route::get( '/', [ Index_Controller::class, 'home' ] );
			Route::get( '/home', [ Index_Controller::class, 'home' ] );
		}
	}

	/**
	 * For checking if the request uri is for 'wp-app'
	 *
	 * @return bool
	 */
	protected function is_wp_app_mode(): bool {
		$wp_app_prefix = enpii_base_get_wp_app_prefix();
		$uri = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( $_SERVER['REQUEST_URI'] ) : '/';
		return ( strpos( $uri, '/' . $wp_app_prefix . '/' ) === 0 || $uri === '/' . $wp_app_prefix );
	}
}
