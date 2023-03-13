<?php

namespace Enpii\WP_Plugin\Enpii_Base\Tests\Unit\Hook_Handlers;

use Enpii\WP_Plugin\Enpii_Base\App\Providers\Filesystem_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\App\Providers\Log_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\App\Providers\Route_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\App\Providers\View_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\Handlers\Register_Main_Service_Providers_Handler;
use Enpii\WP_Plugin\Enpii_Base\Libs\Generic_Command;
use Enpii\WP_Plugin\Enpii_Base\Tests\Support\Unit\Libs\Unit_Test_Case;

class Register_Main_Service_Providers_Hook_Handler_Test extends Unit_Test_Case {
	public function test_handle(): void {
		$genenic_command = new Generic_Command($this->wp_app);
		( new Register_Main_Service_Providers_Handler() )->handle($genenic_command);

		// We need to ensure all the main service providers are registered
		$this->assertNotEmpty( $this->wp_app->getProvider( Log_Service_Provider::class ), 'Log Service is not registered' );
		$this->assertNotEmpty( $this->wp_app->getProvider( Route_Service_Provider::class ), 'Route Service is not registered' );
		$this->assertNotEmpty( $this->wp_app->getProvider( View_Service_Provider::class ), 'View Service is not registered' );
		$this->assertNotEmpty( $this->wp_app->getProvider( Filesystem_Service_Provider::class ), 'Filesystem is not registered' );
	}
}
