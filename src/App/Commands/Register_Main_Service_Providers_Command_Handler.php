<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Commands;

use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Base_Command_Handler;

class Register_Main_Service_Providers_Command_Handler extends Base_Command_Handler {
	public function handle( Register_Main_Service_Providers_Command $command ): void {
		$wp_app = $command->get_wp_app();
		foreach ($command->get_providers() as $provider_classname) {
			$wp_app->register( $provider_classname );
		}
	}
}
