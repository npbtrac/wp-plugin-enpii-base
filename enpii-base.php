<?php
/**
 * Plugin Name: Enpii Base
 * Plugin URI:  https://enpii.com/
 * Description: Base plugin for WP development using Laravel
 * Author:      dev@enpii.com, nptrac@yahoo.com
 * Author URI:  https://enpii.com/
 * Version:     0.2.3
 * Text Domain: enpii
 */

// Update these constants whenever you bump the version
defined( 'ENPII_BASE_PLUGIN_VERSION' ) || define( 'ENPII_BASE_PLUGIN_VERSION', '0.2.3' );

// We set the slug for the plugin here.
// This slug will be used to identify the plugin instance from the WP_Applucation container
defined( 'ENPII_BASE_PLUGIN_SLUG' ) || define( 'ENPII_BASE_PLUGIN_SLUG', 'enpii-base' );

// General fixed constants
defined( 'DIR_SEP' ) || define( 'DIR_SEP', DIRECTORY_SEPARATOR );

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

enpii_base_setup_wp_app();

// We register Enpii_Base plugin as a Service Provider
wp_app()->register_plugin(
	\Enpii_Base\App\WP\Enpii_Base_WP_Plugin::class,
	ENPII_BASE_PLUGIN_SLUG,
	__DIR__,
	plugin_dir_url( __FILE__ )
);
