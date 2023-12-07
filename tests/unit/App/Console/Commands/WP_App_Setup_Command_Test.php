<?php

declare(strict_types=1);

namespace Enpii_Base\Tests\Unit\App\Console\Commands;

use Enpii_Base\App\Console\Commands\WP_App_Setup_Command;
use Enpii_Base\App\Jobs\Setup_WP_App_In_Console_Job;
use Enpii_Base\Tests\Support\Unit\Libs\Unit_Test_Case;
use Mockery;

class WP_App_Setup_Command_Test extends Unit_Test_Case {

	public function test_handle(): void {
		// Mock the WP_App_Setup_Command class
		$command_mock = $this->getMockBuilder( WP_App_Setup_Command::class )
							->disableOriginalConstructor()
							->getMock();

		// Mock the Setup_WP_App_In_Console_Job class
		$console_job = Mockery::mock( Setup_WP_App_In_Console_Job::class );

		// Dispatch the job synchronously and assert that the mock objects and their methods were called as expected
		$console_job->shouldReceive( 'dispatchSync' )
					->with( $command_mock )
					->andReturnSelf();

		$command_mock->handle();
	}
}
