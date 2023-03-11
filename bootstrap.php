<?php

// First we need to load the composer autoloader, so we can use WP Mock
require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap WP_Mock to initialize built-in features
WP_Mock::setUsePatchwork( true );
WP_Mock::bootstrap();

/**
 * Now we include any plugin files that we need to be able to run the tests. This
 * should be files that define the functions and classes you're going to test.
 */
require_once __DIR__ . '/enpii-base.php';
