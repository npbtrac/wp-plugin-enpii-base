<?php

declare(strict_types=1);

namespace Enpii_Base\Tests\Unit\App\Console\Commands;

use Enpii_Base\App\Console\Commands\Job_Make_Command;
use Enpii_Base\Tests\Support\Unit\Libs\Unit_Test_Case;
use Illuminate\Foundation\Console\JobMakeCommand;

class Job_Make_Command_Test extends Unit_Test_Case {

	public function test_construct(): void {
		// Mock the Job_Make_Command class
		$job_command_mock = $this->getMockBuilder( Job_Make_Command::class )
								->disableOriginalConstructor()
								->getMock();

		// Assert that the mock object is an instance of JobMakeCommand
		$this->assertInstanceOf( JobMakeCommand::class, $job_command_mock );
	}
}
