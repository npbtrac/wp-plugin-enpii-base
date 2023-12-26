<?php
$enpii_base_existed = defined( 'ENPII_BASE_PLUGIN_VERSION' );

// General fixed constants
defined( 'DIR_SEP' ) || define( 'DIR_SEP', DIRECTORY_SEPARATOR );

// Update these constants whenever you bump the version
defined( 'ENPII_BASE_PLUGIN_VERSION' ) || define( 'ENPII_BASE_PLUGIN_VERSION', '0.2.3' );

// We set the slug for the plugin here.
// This slug will be used to identify the plugin instance from the WP_Applucation container
defined( 'ENPII_BASE_PLUGIN_SLUG' ) || define( 'ENPII_BASE_PLUGIN_SLUG', 'enpii-base' );

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
if ( version_compare( phpversion(), '8.1.0', '<' ) ) {
	// Lower that 8.1, we load dependencies for <= 8.0, we use Laravel 7
	$autoload_file = __DIR__ . DIR_SEP . 'vendor-legacy' . DIR_SEP . 'autoload.php';
} else {
	// PHP >= 8.1, we use Laravel 10 as the latest
	$autoload_file = __DIR__ . DIR_SEP . 'vendor' . DIR_SEP . 'autoload.php';
}

if (file_exists($autoload_file) && !$enpii_base_existed) {
	require_once $autoload_file;
}
