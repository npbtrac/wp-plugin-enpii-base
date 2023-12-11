<?php

declare(strict_types=1);

namespace Enpii_Base\Tests\Unit\App\Jobs;

use Enpii_Base\App\Jobs\Init_WP_App_Bootstrap_Job;
use Enpii_Base\Tests\Support\Unit\Libs\Unit_Test_Case;

class Init_WP_App_Bootstrap_Job_Test extends Unit_Test_Case {

	public function test_handle(): void {
		$this->setup_wp_app();
		$wp_app = $this->wp_app;

		// Mock the Init_WP_App_Bootstrap_Job class
		$wp_app_bootstrap_job_mock = $this->getMockBuilder( Init_WP_App_Bootstrap_Job::class )->getMock();
		$wp_app_bootstrap_job_mock->handle();

		$http_kernel = $wp_app->make( \Enpii_Base\App\Http\Kernel::class );
		$console_kernel = $wp_app->make( \Enpii_Base\App\Console\Kernel::class );
		$exception_handler = $wp_app->make( \Enpii_Base\App\Exceptions\Handler::class );

		// Assert that the resolved instances match the expected classes
		$this->assertInstanceOf( \Illuminate\Contracts\Http\Kernel::class, $http_kernel );
		$this->assertInstanceOf( \Illuminate\Contracts\Console\Kernel::class, $console_kernel );
		$this->assertInstanceOf( \Illuminate\Contracts\Debug\ExceptionHandler::class, $exception_handler );
	}
}
