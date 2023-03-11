<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Handlers;

use Enpii\WP_Plugin\Enpii_Base\App\Providers\Filesystem_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\App\Providers\Log_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\App\Providers\Route_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\App\Providers\View_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\Libs\Base_Handler;

class Register_Main_Service_Providers_Handler extends Base_Handler {
	public function handle(): void {
		$wp_app = $this->get_wp_app();
		$wp_app->register( Log_Service_Provider::class );
		$wp_app->register( Route_Service_Provider::class );
		$wp_app->register( View_Service_Provider::class );
		$wp_app->register( Filesystem_Service_Provider::class );
	}
}
