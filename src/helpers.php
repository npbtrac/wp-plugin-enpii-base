<?php

declare(strict_types=1);

use Illuminate\Filesystem\Filesystem;

if ( ! function_exists( 'enpii_base_get_laravel_version' ) ) {
	function enpii_base_get_major_version( $version ): int {
		$parts = explode( '.', $version );
		return (int) filter_var( $parts[0], FILTER_SANITIZE_NUMBER_INT );
	}
}

if ( ! function_exists( 'enpii_base_setup_wp_app' ) ) {
	function enpii_base_setup_wp_app() {
		// We only want to run the setup once
		if ( \Enpii_Base\App\WP\WP_Application::isset() ) {
			return;
		}

		/**
		| Create a wp_app() instance to be used in the whole application
		*/
		$wp_app_base_path = enpii_base_wp_app_get_base_path();
		$config = apply_filters(
			'enpii_base_wp_app_prepare_config',
			[
				'app'         => require_once dirname( __DIR__ ) . DIR_SEP . 'wp-app-config' . DIR_SEP . 'app.php',
				'wp_app_slug' => ENPII_BASE_WP_APP_PREFIX,
				'wp_api_slug' => ENPII_BASE_WP_API_PREFIX,
			]
		);
		// We initiate the WP Application instance
		\Enpii_Base\App\WP\WP_Application::init_instance_with_config(
			$wp_app_base_path,
			$config
		);
	}
}

if ( ! function_exists( 'enpii_base_wp_app_prepare_folders' ) ) {
	function enpii_base_wp_app_prepare_folders( string $wp_app_base_path ): void {
		$file_system = new Filesystem();
		$file_system->ensureDirectoryExists( $wp_app_base_path, 0755 );

		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'bootstrap', 0755 );
		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'bootstrap' . DIR_SEP . 'cache', 0777 );

		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'lang', 0755 );
		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'resources', 0755 );

		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'storage', 0777 );
		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'storage' . DIR_SEP . 'logs', 0777 );
		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'storage' . DIR_SEP . 'framework', 0777 );
		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'storage' . DIR_SEP . 'framework' . DIR_SEP . 'views', 0777 );
		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'storage' . DIR_SEP . 'framework' . DIR_SEP . 'cache', 0777 );
		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'storage' . DIR_SEP . 'framework' . DIR_SEP . 'cache' . DIR_SEP . 'data', 0777 );

		$file_system->chmod( $wp_app_base_path . DIR_SEP . 'bootstrap' . DIR_SEP . 'cache', 0777 );
		$file_system->chmod( $wp_app_base_path . DIR_SEP . 'storage', 0777 );
		$file_system->chmod( $wp_app_base_path . DIR_SEP . 'storage' . DIR_SEP . 'framework', 0777 );
		$file_system->chmod( $wp_app_base_path . DIR_SEP . 'storage' . DIR_SEP . 'logs', 0777 );
	}
}

if ( ! function_exists( 'enpii_base_wp_app_get_base_path' ) ) {
	function enpii_base_wp_app_get_base_path() {
		return rtrim( WP_CONTENT_DIR, '/' ) . DIR_SEP . 'uploads' . DIR_SEP . 'wp-app';
	}
}

if ( ! function_exists( 'enpii_base_get_wp_app_prefix' ) ) {
	function enpii_base_get_wp_app_prefix(): string {
		return ENPII_BASE_WP_APP_PREFIX;
	}
}

if ( ! function_exists( 'enpii_base_get_wp_api_prefix' ) ) {
	function enpii_base_get_wp_api_prefix(): string {
		return ENPII_BASE_WP_API_PREFIX;
	}
}

if ( ! function_exists( 'enpii_base_wp_cli_register_commands' ) ) {
	function enpii_base_wp_cli_register_commands(): void {
		\WP_CLI::add_command( 'enpii-base', Enpii_Base\App\WP_CLI\Enpii_Base_WP_CLI::class );
	}
}
