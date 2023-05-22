<?php

namespace Enpii_Base\Tests\Unit\Base\Handlers;

use Codeception\Stub;
use Enpii_Base\App\Http\Kernel;
use Enpii_Base\Deps\Illuminate\Foundation\Application;
use Enpii_Base\Handlers\Process_WP_App_Request_Handler;
use Enpii_Base\Handlers\Register_Main_Service_Providers_Handler;
use Enpii_Base\Libs\Generic_Command;
use Enpii_Base\Tests\Support\Unit\Libs\Unit_Test_Case;

class Process_WP_App_Request_Handler_Test extends Unit_Test_Case {
	public function test_handle(): void {
		$generic_command = new Generic_Command($this->wp_app);
		(new Register_Main_Service_Providers_Handler())->handle($generic_command);

		$wp_app_hook_handler = Stub::make(Process_WP_App_Request_Handler::class, [
			'process_http_request' => Stub\Expected::once(),
			'process_http_request' => function () {
				return true;
			}
		]);
		$wp_app_hook_handler->handle($generic_command);

		$this->assertNotEmpty($this->wp_app->bound(\Enpii_Base\Deps\Illuminate\Contracts\Http\Kernel::class),
			'Http Kernel is not bound');
		$this->assertNotEmpty($this->wp_app->bound(\Enpii_Base\Deps\Illuminate\Contracts\Console\Kernel::class),
			'Console Kernel is not bound');
		$this->assertNotEmpty($this->wp_app->bound(\Enpii_Base\Deps\Illuminate\Contracts\Debug\ExceptionHandler::class),
			'Exception Handler is not bound');
	}
}
