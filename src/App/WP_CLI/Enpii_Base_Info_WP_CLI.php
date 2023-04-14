<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\WP_CLI;

use Enpii\WP_Plugin\Enpii_Base\App\Commands\Register_Main_Service_Providers_Command_Handler;
use WP_CLI;

class Enpii_Base_Info_WP_CLI {
	public function __invoke( $args ) {
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
