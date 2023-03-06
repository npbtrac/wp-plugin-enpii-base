<?php

declare(strict_types=1);

namespace Enpii\Wp_Plugin\Enpii_Base\Base\Hook_Handlers;

use Enpii\WP_Plugin\Enpii_Base\App\Providers\Filesystem_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\App\Providers\Log_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\App\Providers\Route_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\App\Providers\View_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\Libs\Wp_Base_Hook_Handler;

class Register_Main_Service_Providers_Hook_Handler extends WP_Base_Hook_Handler {
	public function handle(): void {
		$wp_app = wp_app();
		$wp_app->register( Log_Service_Provider::class );
		$wp_app->register( Route_Service_Provider::class );
		$wp_app->register( View_Service_Provider::class );
		$wp_app->register( Filesystem_Service_Provider::class );
	}
}
