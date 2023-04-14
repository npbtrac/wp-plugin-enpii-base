<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\WP;

use Enpii\WP_Plugin\Enpii_Base\App\Commands\Process_WP_App_Request_Command;
use Enpii\WP_Plugin\Enpii_Base\App\Commands\Process_WP_App_Request_Command_Handler;
use Enpii\WP_Plugin\Enpii_Base\App\Commands\Register_Base_WP_App_Routes_Command_Handler;
use Enpii\WP_Plugin\Enpii_Base\App\Commands\Register_Main_Service_Providers_Command;
use Enpii\WP_Plugin\Enpii_Base\App\Commands\Register_Main_Service_Providers_Command_Handler;
use Enpii\WP_Plugin\Enpii_Base\Foundation\WP\WP_Plugin;
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
		parent::register();

		// We want to register main providers here
		do_action( 'enpii_base_register_main_service_providers' );
	}

	public function manipulate_hooks(): void {
		// We want to start processing wp-app requests after all plugins and theme loaded
		add_action( 'init', [ $this, 'process_wp_app_request' ], 9999 );

		// WP CLI
		add_action( 'cli_init', [ $this, 'register_wp_cli_commands' ] );

		// WP App hooks
		add_action( 'enpii_base_wp_app_register_routes', [ $this, 'register_base_wp_app_routes' ] );

		// General hooks
		add_action( 'enpii_base_register_main_service_providers', [ $this, 'register_main_service_providers' ] );
	}

	public function register_main_service_providers(): void {
		/**
		| We want to register main Service Providers for the wp_app()
		| You can remove this handler to replace with the Service Providers you want
		 */
		$command = new Register_Main_Service_Providers_Command();
		$command->bind_config([
			'wp_app' => $this->app,
			'providers' => [
				\Enpii\WP_Plugin\Enpii_Base\App\Providers\Filesystem_Service_Provider::class,
				\Enpii\WP_Plugin\Enpii_Base\App\Providers\Log_Service_Provider::class,
				\Enpii\WP_Plugin\Enpii_Base\App\Providers\Route_Service_Provider::class,
				\Enpii\WP_Plugin\Enpii_Base\App\Providers\View_Service_Provider::class,
			],
		]);
		/** @var Register_Main_Service_Providers_Command_Handler $command_handler */
		$command_handler = $this->app->make(Register_Main_Service_Providers_Command_Handler::class);
		$command_handler->handle($command);
	}

	public function process_wp_app_request(): void {
		// We want to check that if the uri prefix is for wp-app before invoke the handler
		// to keep the handler lazy-loading
		if ( $this->is_wp_app_mode() ) {
			$command = new Process_WP_App_Request_Command();
			$command->bind_config([
				'wp_app' => $this->app,
			]);
			/** @var Process_WP_App_Request_Command_Handler $command_handler */
			$command_handler = $this->app->make(Process_WP_App_Request_Command_Handler::class);
			$command_handler->handle($command);
		}
	}

	public function register_base_wp_app_routes(): void {
		// We want to check that if the uri prefix is for wp-app before invoke the handler
		// to keep the handler lazy-loading
		if ( $this->is_wp_app_mode() ) {
			$this->app->execute_command_handler( Register_Base_WP_App_Routes_Command_Handler::class );
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
}
