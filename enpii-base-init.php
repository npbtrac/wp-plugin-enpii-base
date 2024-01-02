<?php
// We only want to initiate the wp_app() when the WP loaded
//	When we use the composer to load the plugin, this file may be loaded
//	with the composer autoload before the WP loaded
if (defined( 'WP_CONTENT_DIR' )) {
	// We register Enpii_Base plugin as a Service Provider
	//	we should put the closure
	add_action( \Enpii_Base\App\Support\App_Const::ACTION_WP_APP_LOADED, function() {
		wp_app()->register_plugin(
			\Enpii_Base\App\WP\Enpii_Base_WP_Plugin::class,
			ENPII_BASE_PLUGIN_SLUG,
			__DIR__,
			plugin_dir_url( __FILE__ )
		);
	});

	// We init wp_app() here
	//	then initialization in `enpii-base-init.php` file is for non-plugin mode
	\Enpii_Base\App\WP\WP_Application::load_instance();
}
