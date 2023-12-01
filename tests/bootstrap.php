<?php
/**
 * Now we include any plugin files that we need to be able to run the tests. This
 * should be files that define the functions and classes you're going to test.
 */

require_once dirname(__DIR__) . '/bootstrap.php';

function output_debug($string) {
	fwrite(STDERR, print_r($string, true));
}


// Bootstrap WP_Mock to initialize built-in features
WP_Mock::setUsePatchwork( true );
WP_Mock::bootstrap();
