<?php

namespace Enpii\WP_Plugin\Enpii_Base\Tests\Unit\Base\Hook_Handlers;

use Enpii\WP_Plugin\Enpii_Base\App\Providers\Filesystem_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\App\Providers\Log_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\App\Providers\Route_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\App\Providers\View_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\Base\Hook_Handlers\Register_Main_Service_Providers_Hook_Handler;

class Register_Main_Service_Providers_Hook_Handler_Test extends \Codeception\Test\Unit {
	public function test_handle(): void {
		$wp_app = wp_app();
		( new Register_Main_Service_Providers_Hook_Handler() )->handle();

		// We need to ensure all the main service providers are registered
		$this->assertNotEmpty( $wp_app->getProviders( Log_Service_Provider::class ), 'Log Service is not registered' );
		$this->assertNotEmpty( $wp_app->getProviders( Route_Service_Provider::class ), 'Route Service is not registered' );
		$this->assertNotEmpty( $wp_app->getProviders( View_Service_Provider::class ), 'View Service is not registered' );
		$this->assertNotEmpty( $wp_app->getProviders( Filesystem_Service_Provider::class ), 'Filesystem is not registered' );
	}
}
