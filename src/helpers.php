<?php

declare(strict_types=1);

use Enpii_Base\App\Support\App_Const;

if ( ! function_exists( 'enpii_base_is_console_mode' ) ) {
	function enpii_base_is_console_mode(): bool {
		return ( \PHP_SAPI === 'cli' || \PHP_SAPI === 'phpdbg' );
	}
}

if ( ! function_exists( 'enpii_base_get_major_version' ) ) {
	function enpii_base_get_major_version( $version ): int {
		$parts = explode( '.', $version );
		return (int) filter_var( $parts[0], FILTER_SANITIZE_NUMBER_INT );
	}
}

if ( ! function_exists( 'enpii_base_wp_app_prepare_folders' ) ) {
	/**
	 *
	 * @param string|null $wp_app_base_path
	 * @param int $chmod We may want to use `0755` if running this function in console
	 * @return void
	 */
	function enpii_base_wp_app_prepare_folders( $chmod = 0777, string $wp_app_base_path = null ): void {
		if ( empty( $wp_app_base_path ) ) {
			$wp_app_base_path = enpii_base_wp_app_get_base_path();
		}

		$file_system = new \Illuminate\Filesystem\Filesystem();
		$file_system->ensureDirectoryExists( $wp_app_base_path, $chmod );

		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'config', $chmod );

		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'database', $chmod );
		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'database' . DIR_SEP . 'migrations', $chmod );

		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'bootstrap', $chmod );
		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'bootstrap' . DIR_SEP . 'cache', $chmod );

		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'lang', $chmod );
		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'resources', $chmod );

		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'storage', $chmod );
		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'storage' . DIR_SEP . 'logs', $chmod );
		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'storage' . DIR_SEP . 'framework', $chmod );
		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'storage' . DIR_SEP . 'framework' . DIR_SEP . 'views', $chmod );
		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'storage' . DIR_SEP . 'framework' . DIR_SEP . 'cache', $chmod );
		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'storage' . DIR_SEP . 'framework' . DIR_SEP . 'cache' . DIR_SEP . 'data', $chmod );
		$file_system->ensureDirectoryExists( $wp_app_base_path . DIR_SEP . 'storage' . DIR_SEP . 'framework' . DIR_SEP . 'sessions', $chmod );

		$file_system->chmod( $wp_app_base_path . DIR_SEP . 'bootstrap' . DIR_SEP . 'cache', $chmod );
		$file_system->chmod( $wp_app_base_path . DIR_SEP . 'storage', $chmod );
		$file_system->chmod( $wp_app_base_path . DIR_SEP . 'storage' . DIR_SEP . 'framework', $chmod );
		$file_system->chmod( $wp_app_base_path . DIR_SEP . 'storage' . DIR_SEP . 'logs', $chmod );
	}
}

if ( ! function_exists( 'enpii_base_wp_app_get_base_path' ) ) {
	function enpii_base_wp_app_get_base_path() {
		if (defined( 'ENPII_BASE_WP_APP_BASE_PATH' ) && ENPII_BASE_WP_APP_BASE_PATH) {
			return ENPII_BASE_WP_APP_BASE_PATH;
		} else {
			return WP_CONTENT_DIR . DIR_SEP . 'uploads' . DIR_SEP . 'wp-app';
		}
	}
}

if ( ! function_exists( 'enpii_base_wp_app_web_page_title' ) ) {
	function enpii_base_wp_app_web_page_title() {
		$title = empty( wp_title( '', false ) ) ? get_bloginfo( 'name' ) . ' | ' . ( get_bloginfo( 'description' ) ?: 'WP App' ) : wp_title( '', false );

		return apply_filters( App_Const::FILTER_WP_APP_WEB_PAGE_TITLE, $title );
	}
}

if ( ! function_exists( 'enpii_base_prepare' ) ) {
	function enpii_base_prepare() {
		WP_CLI::add_command(
			'enpii-base prepare',
			function () {
				enpii_base_wp_app_prepare_folders();
			}
		);
	}
}
