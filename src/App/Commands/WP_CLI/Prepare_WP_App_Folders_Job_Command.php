<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Commands\WP_CLI;

use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Base_Job_Command;

class Prepare_WP_App_Folders_Job_Command extends Base_Job_Command {
	public function handle(): void {
		$wp_app_base_path = enpii_base_wp_app_get_base_path();
		enpii_base_wp_app_prepare_folders( $wp_app_base_path );
	}
}
