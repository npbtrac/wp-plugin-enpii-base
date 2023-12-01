<?php
// General fixed constants
defined( 'DIR_SEP' ) || define( 'DIR_SEP', DIRECTORY_SEPARATOR );

// The prefix for wp_app request
defined( 'ENPII_BASE_WP_APP_PREFIX' ) || define(
	'ENPII_BASE_WP_APP_PREFIX',
	!empty( getenv( 'ENPII_BASE_WP_APP_PREFIX' ) ) ? : 'wp-app'
);

defined( 'ENPII_BASE_WP_API_PREFIX' ) || define(
	'ENPII_BASE_WP_API_PREFIX',
	!empty( getenv( 'ENPII_BASE_WP_API_PREFIX' ) ) ? : 'wp-api'
);

require_once __DIR__ . DIR_SEP . 'src' . DIR_SEP . 'helpers.php';

// We include the vendor in the repo if there is no vendor loaded before
if ( ! class_exists( \Enpii_Base\App\WP\WP_Application::class ) ) {
	if ( version_compare( phpversion(), '8.1.0', '<' ) ) {
		// Lower that 8.1, we load dependencies for <= 8.0, we use Laravel 7
		require_once __DIR__ . DIR_SEP . 'vendor-laravel7' . DIR_SEP . 'autoload.php';
	} else {
		// PHP >= 8.1, we use Laravel 10 as the latest
		require_once __DIR__ . DIR_SEP . 'vendor' . DIR_SEP . 'autoload.php';
	}
}
