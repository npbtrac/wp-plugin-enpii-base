<?php
/**
 * Declare helper functions to offer convenience on calling method without namespaces
 */

if ( ! defined( 'ENPII_BASE_USE_HELPERS' ) || ! ENPII_BASE_USE_HELPERS ) {
	if ( ! function_exists( 'wp_app' ) ) {
		function wp_app() {
			return Yii::$app;
		}
	}

	if ( ! function_exists( 'is_console_application' ) ) {
		function is_console_application() {
			return in_array( php_sapi_name(), [ 'cli', 'phpdbg' ] );
		}
	}
}
