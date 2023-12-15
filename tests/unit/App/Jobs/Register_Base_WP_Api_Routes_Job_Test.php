<?php

declare(strict_types=1);

namespace Enpii_Base\Tests\Unit\App\Jobs;

use Enpii_Base\App\Jobs\Register_Base_WP_Api_Routes_Job;
use Enpii_Base\Tests\Support\Unit\Libs\Unit_Test_Case;

class Register_Base_WP_Api_Routes_Job_Test extends Unit_Test_Case {

	public function test_handle() {
		$this->setup_wp_app();
		$wpAppMock = \Mockery::mock( 'alias:wp_app' );
		$wpAppMock->shouldReceive( 'is_debug_mode' )->once()->andReturnTrue();

		// Create an instance of Register_Base_WP_Api_Routes_Job
		$job = $this->getMockBuilder( Register_Base_WP_Api_Routes_Job::class )->getMock();
		// Call the handle() method
		$job->handle();

		//Todo: We need to handle Laravel to get routes registered
	}
}
