<?php
/**
 * Plugin Name: Enpii Base
 * Description: The Base plugin for Theme and Plugin development. It requires ACF pro to work.
 * Version: 0.0.1
 * Author: Enpii
 * Author URI: http://www.enpii.com/wordpress-plugin-enpii-base
 * License: GPLv2 or later
 * Text Domain: enpii
 * Domain Path: /languages/
 */

declare(strict_types=1);

use Enpiicom\WpPlugin\EnpiiBase\EnpiiBasePlugin;
use Enpiicom\WpPlugin\EnpiiBase\Base\WpApp;
use Enpiicom\WpPlugin\EnpiiBase\Helpers\ConfigHelper;
use Illuminate\Config\Repository as ConfigRepository;

// Use autoload if it isn't loaded before.
if (!class_exists(EnpiiBasePlugin::class)) {
    require_once __DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
}

if (!function_exists('enpii_base_init_wp_app_config')) {
    /**
     * Initialize global configuration
     */
    function enpii_base_init_wp_app_config(): array
    {
        $config = require_once(__DIR__.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'wp-app.php');

        return apply_filters('enpii-base/wp-app-config', $config);
    }
}

if (!function_exists('enpii_base_apply_plugin_config')) {
    /**
     * Initialize global configuration
     *
     * @param array Configurations
     *
     * @return array
     */
    function enpii_base_apply_plugin_config(array $config): array
    {
        $config = ConfigHelper::setPluginConfig($config, [
            EnpiiBasePlugin::class => require_once(__DIR__.DIRECTORY_SEPARATOR.'config.php'),
        ]);

        return $config;
    }
}
add_filter('enpii-base/wp-app-config', 'enpii_base_apply_plugin_config');

if ( ! function_exists( 'enpii_base_setup_wp_app_rewrite_rules' ) ) {
    /**
     * Make `wp-app` to work with Yii
     */
    function enpii_base_setup_wp_app_rewrite_rules() {
        global $wp_query, $wp_rewrite;

        dump($wp_query);
        dump($wp_rewrite);

        die('asdf');
    }
}
//add_action( 'parse_query', 'enpii_base_setup_wp_app_rewrite_rules', 1 );

if (!function_exists('enpii_base_init_wp_app')) {
    function enpii_base_init_wp_app()
    {
        $config = enpii_base_init_wp_app_config();
        $wpApp = new WpApp(__DIR__);
        $wpApp->singleton('config', function (WpApp $app) use ($config) : ConfigRepository {
            return new ConfigRepository($config);
        });
        $wpApp->registerPlugins();
    }
}
add_action('after_setup_theme', 'enpii_base_init_wp_app');