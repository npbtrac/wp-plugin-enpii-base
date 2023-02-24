<?php
/**
 * Plugin Name: Enpii Base
 * Plugin URI:  https://enpii.com/
 * Description: Base plugin for WP development
 * Author:      dev@enpii.com, nptrac@yahoo.com
 * Author URI:  https://enpii.com/
 * Version:     0.0.1
 * Text Domain: enpii
 */

// Update these constants whenever you bump the version
defined( 'ENPII_BASE_VERSION' ) || define( 'ENPII_BASE_PLUGIN_VERSION', '0.0.1' );

// General fixed constants
defined( 'DIR_SEP' ) || define( 'DIR_SEP', DIRECTORY_SEPARATOR );

// We include composer autoload here
if ( ! class_exists( Enpii\Wp_Plugin\Enpii_Base\Libs\Wp_Application::class ) ) {
	require_once __DIR__ . DIR_SEP . 'vendor' . DIR_SEP . 'autoload.php';
}

// Plugin constants
defined( 'ENPII_BASE_PLUGIN_SLUG' ) || define( 'ENPII_BASE_PLUGIN_SLUG', 'enpii-base' );
defined( 'ENPII_BASE_WP_APP_PREFIX' ) || define( 'ENPII_BASE_WP_APP_PREFIX', env('ENPII_BASE_WP_APP_PREFIX', 'wp-app') );

/**
 | WP CLI handlers
 |
 */
add_action( 'cli_init', 'enpii_base_wp_cli_register_commands' );

/**
 | Create a wp_app() instance to be used in the whole application
 */
$wp_app_base_path = enpii_base_wp_app_get_base_path();
$config = apply_filters( 'enpii_base_wp_app_prepare_config', [
	'app' => require_once __DIR__ . DIR_SEP . 'wp-app-config' . DIR_SEP . 'app.php',
] );
$wp_app = ( new \Enpii\Wp_Plugin\Enpii_Base\Libs\Wp_Application( $wp_app_base_path ) )->init_config( $config );

// We register Enpii_Base plugin as a Service Provider
$enpii_base_plugin = new \Enpii\Wp_Plugin\Enpii_Base\Base\Plugin($wp_app);
$enpii_base_plugin->set_base_path(__DIR__);
$enpii_base_plugin->set_base_url(plugin_dir_url( __FILE__ ));
$wp_app->register( $enpii_base_plugin );
