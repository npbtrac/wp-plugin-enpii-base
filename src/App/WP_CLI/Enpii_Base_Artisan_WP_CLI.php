<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\WP_CLI;

use WP_CLI;

class Enpii_Base_Artisan_WP_CLI {
	public function __invoke( $args, $options ) {
		/** @var \Enpii\WP_Plugin\Enpii_Base\App\Console\Kernel $kernel */
		$kernel = wp_app()->make( \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Console\Kernel::class );
		// dev_error_log($kernel);
		dev_dump($args);
		dev_dump($options);
		$kernel->call($args, $options);
		WP_CLI::success(
			sprintf(
				'Running Enpii Base plugin version %s on WordPress %s and PHP %s',
				ENPII_BASE_PLUGIN_VERSION,
			get_bloginfo('version'),
				PHP_VERSION
			)
		);
    }
}
