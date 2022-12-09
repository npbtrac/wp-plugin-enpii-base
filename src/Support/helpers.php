<?php

declare(strict_types=1);

use Enpii\Wp_Plugin\Enpii_Base\Base\Plugin;
use Enpii\Wp_Plugin\Enpii_Base\Base\Wp_Cli\Enpii_Base_Wp_Cli;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Filesystem\Filesystem;
use Enpii\Wp_Plugin\Enpii_Base\Libs\Wp_Application;

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

if ( ! function_exists( 'enpii_base_wp_cli_register_commands' ) ) {
	function enpii_base_wp_cli_register_commands(): void {
		\WP_CLI::add_command( 'enpii-base', Enpii_Base_Wp_Cli::class );
	}
}
