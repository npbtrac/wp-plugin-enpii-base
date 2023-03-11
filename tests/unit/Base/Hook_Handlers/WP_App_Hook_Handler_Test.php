<?php

namespace Enpii\WP_Plugin\Enpii_Base\Tests\Unit\Base\Hook_Handlers;

use Codeception\Stub;
use Enpii\WP_Plugin\Enpii_Base\App\Http\Kernel;
use Enpii\WP_Plugin\Enpii_Base\Base\Hook_Handlers\Register_Main_Service_Providers_Hook_Handler;
use Enpii\WP_Plugin\Enpii_Base\Base\Hook_Handlers\WP_App_Hook_Handler;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Application;
use Enpii\WP_Plugin\Enpii_Base\Libs\WP_Base_Hook_Handler;
use Enpii\WP_Plugin\Enpii_Base\Tests\Support\Unit\Libs\Unit_Test_Case;

class WP_App_Hook_Handler_Test extends Unit_Test_Case {
	public function test_handle(): void {
		(new Register_Main_Service_Providers_Hook_Handler())->handle();

		$wp_app_hook_handler = Stub::make(WP_App_Hook_Handler::class, [
			'process_http_request' => Stub\Expected::once(),
			'process_http_request' => function () {
				return true;
			}
		]);
		$wp_app_hook_handler->handle();

		$this->assertNotEmpty($this->wp_app->bound(\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Http\Kernel::class),
			'Http Kernel is not bound');
		$this->assertNotEmpty($this->wp_app->bound(\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Console\Kernel::class),
			'Console Kernel is not bound');
		$this->assertNotEmpty($this->wp_app->bound(\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Debug\ExceptionHandler::class),
			'Exception Handler is not bound');
	}
}
