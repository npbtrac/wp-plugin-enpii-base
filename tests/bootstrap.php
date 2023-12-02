<?php
/**
 * Now we include any plugin files that we need to be able to run the tests. This
 * should be files that define the functions and classes you're going to test.
 */

require_once dirname( __DIR__ ) . '/enpii-base-bootstrap.php';

function output_debug( $debug_string ) {
	// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r, WordPressVIPMinimum.Functions.RestrictedFunctions.file_ops_fwrite
	fwrite( STDERR, print_r( $debug_string, true ) );
}

// Bootstrap WP_Mock to initialize built-in features
WP_Mock::setUsePatchwork( true );
WP_Mock::bootstrap();
