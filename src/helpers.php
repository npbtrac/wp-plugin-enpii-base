<?php

declare(strict_types=1);

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

		// The prefix for wp_app request
		defined( 'ENPII_BASE_WP_APP_PREFIX' ) || define(
			'ENPII_BASE_WP_APP_PREFIX',
			env( 'ENPII_BASE_WP_APP_PREFIX', 'wp-app' )
		);

		defined( 'ENPII_BASE_WP_API_PREFIX' ) || define(
			'ENPII_BASE_WP_API_PREFIX',
			env( 'ENPII_BASE_WP_API_PREFIX', 'wp-api' )
		);

		/**
		| Create a wp_app() instance to be used in the whole application
		*/
		$wp_app_base_path = enpii_base_wp_app_get_base_path();
		$config = apply_filters(
			'enpii_base_wp_app_prepare_config',
			array(
				'app'         => require_once dirname( __DIR__ ) . DIR_SEP . 'wp-app-config' . DIR_SEP . 'app.php',
				'wp_app_slug' => ENPII_BASE_WP_APP_PREFIX,
				'wp_api_slug' => ENPII_BASE_WP_API_PREFIX,
			) 
		);
		// We initiate the WP Application instance
		\Enpii_Base\App\WP\WP_Application::init_instance_with_config(
			$wp_app_base_path,
			$config
		);
	}
}
