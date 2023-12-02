<?php
// We only want to initiate the wp_app() when the WP loaded
//	When we use the composer to load the plugin, this file may be loaded
//	with the composer autoload before the WP loaded
if (defined( 'WP_CONTENT_DIR' )) {
	enpii_base_setup_wp_app();

	// We register Enpii_Base plugin as a Service Provider
	wp_app()->register_plugin(
		\Enpii_Base\App\WP\Enpii_Base_WP_Plugin::class,
		ENPII_BASE_PLUGIN_SLUG,
		__DIR__,
		plugin_dir_url( __FILE__ )
	);
}
