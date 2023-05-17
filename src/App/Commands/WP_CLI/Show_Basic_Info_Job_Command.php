<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Commands\WP_CLI;

use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Base_Job_Command;
use WP_CLI;

class Show_Basic_Info_Job_Command extends Base_Job_Command {
	public function handle(): void {
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
