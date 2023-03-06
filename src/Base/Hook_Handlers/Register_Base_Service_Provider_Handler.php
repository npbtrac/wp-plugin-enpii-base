<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Base\Hook_Handlers;

use Enpii\WP_Plugin\Enpii_Base\Libs\WP_Base_Hook_Handler;

class Register_Base_Service_Provider_Handler extends WP_Base_Hook_Handler {
	public function handle(): void {
		$wp_app = wp_app();
		$wp_app->make( 'config' )->get( 'logging' )['default'] = 5;
	}
}
