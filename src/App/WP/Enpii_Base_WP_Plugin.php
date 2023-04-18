<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\WP;

use Enpii\WP_Plugin\Enpii_Base\App\Commands\Init_WP_App_Bootstrap_Command_Handler;
use Enpii\WP_Plugin\Enpii_Base\App\Commands\Process_WP_App_Request_Command;
use Enpii\WP_Plugin\Enpii_Base\App\Commands\Process_WP_App_Request_Command_Handler;
use Enpii\WP_Plugin\Enpii_Base\App\Commands\Register_Base_WP_App_Routes_Command_Handler;
use Enpii\WP_Plugin\Enpii_Base\App\Commands\Register_Main_Service_Providers_Command;
use Enpii\WP_Plugin\Enpii_Base\App\Commands\Register_Main_Service_Providers_Command_Handler;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Container\BindingResolutionException;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Providers\ArtisanServiceProvider;
use Enpii\WP_Plugin\Enpii_Base\Foundation\WP\WP_Plugin;
use InvalidArgumentException;
use WP_CLI;

/**
 * @package Enpii\WP_Plugin\Enpii_Base\App\WP
 */
final class Enpii_Base_WP_Plugin extends WP_Plugin {
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		// We need to ensure all needed properties are set
		$this->validate_needed_properties();

		// We want to create hooks for this plugin here
		$this->enroll_self_hooks();

		// We want to handle the hooks first
		$this->manipulate_hooks();

		// We trigger the action when wp_app loaded
		do_action( 'enpii_base_wp_app_loaded' );
	}

	public function manipulate_hooks(): void {
		// WP CLI
		add_action( 'cli_init', [ $this, 'register_wp_cli_commands' ] );

		// WP App hooks

		// We want to initialize wp_app bootstrap after plugins loaded
		add_action( 'enpii_base_wp_app_bootstrap', [ $this, 'bootstrap_wp_app' ], 5 );

		// We want to start processing wp-app requests after all plugins and theme loaded
		add_action( 'enpii_base_wp_app_init', [ $this, 'process_wp_app_request' ], 20 );
		add_action( 'enpii_base_wp_app_init', [ $this, 'register_main_service_providers' ] );

		add_action( 'enpii_base_wp_app_register_routes', [ $this, 'register_base_wp_app_routes' ] );

		// // General hooks
		// add_action( 'enpii_base_register_main_service_providers', [ $this, 'register_main_service_providers' ] );
	}

	public function bootstrap_wp_app(): void {
		wp_app_dispatch_command_handler( Init_WP_App_Bootstrap_Command_Handler::class );
	}

	/**
	 * We want to register main Service Providers for the wp_app()
	 * You can remove this handler to replace with the Service Providers you want
	 * @return void
	 * @throws BindingResolutionException
	 * @throws InvalidArgumentException
	 */
	public function register_main_service_providers(): void {
		wp_app_dispatch_command_handler( Register_Main_Service_Providers_Command_Handler::class, (new Register_Main_Service_Providers_Command()) );
	}

	public function process_wp_app_request(): void {
		// We want to check that if the uri prefix is for wp-app before invoke the handler
		// to keep the handler lazy-loading
		if ( $this->is_wp_app_mode() ) {
			wp_app_dispatch_command_handler( Process_WP_App_Request_Command_Handler::class, (new Process_WP_App_Request_Command())->bind_config([
				'wp_app' => $this->app,
			]) );
		}
	}

	public function register_base_wp_app_routes(): void {
		// We want to check that if the uri prefix is for wp-app before invoke the handler
		// to keep the handler lazy-loading
		if ( $this->is_wp_app_mode() ) {
			wp_app_dispatch_command_handler( Register_Base_WP_App_Routes_Command_Handler::class );
		}
	}

	public function register_wp_cli_commands(): void {
		WP_CLI::add_command(
			'enpii-base info',
			wp_app_resolve(\Enpii\WP_Plugin\Enpii_Base\App\WP_CLI\Enpii_Base_Info_WP_CLI::class)
		);
		WP_CLI::add_command(
			'enpii-base prepare-folders',
			$this->app->make(\Enpii\WP_Plugin\Enpii_Base\App\WP_CLI\Enpii_Base_Prepare_Folders_WP_CLI::class)
		);
		WP_CLI::add_command(
			'enpii-base artisan',
			$this->app->make(\Enpii\WP_Plugin\Enpii_Base\App\WP_CLI\Enpii_Base_Artisan_WP_CLI::class)
		);
	}

	/**
	 * For checking if the request uri is for 'wp-app'
	 *
	 * @return bool
	 */
	public function is_wp_app_mode(): bool {
		$wp_app_prefix = enpii_base_get_wp_app_prefix();
		$uri = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( $_SERVER['REQUEST_URI'] ) : '/';
		return ( strpos( $uri, '/' . $wp_app_prefix . '/' ) === 0 || $uri === '/' . $wp_app_prefix );
	}

	public function wp_app_bootstrap(): void {
		do_action( 'enpii_base_wp_app_bootstrap' );
	}

	public function wp_app_init(): void {
		do_action( 'enpii_base_wp_app_init' );
	}

	/**
	 * All hooks created by this plugin should be enrolled here
	 * @return void
	 */
	private function enroll_self_hooks(): void {
		// For `enpii_base_wp_app_bootstrap`
		add_action( 'plugins_loaded', [ $this, 'wp_app_bootstrap' ], 5 );

		// For `enpii_base_wp_app_init`
		add_action( 'init', [$this, 'wp_app_init'], 9999 );
	}
}
