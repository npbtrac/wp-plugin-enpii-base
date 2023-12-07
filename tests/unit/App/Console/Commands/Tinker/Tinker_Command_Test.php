<?php

namespace Enpii_Base\Tests\Unit\App\Console\Commands\Tinker;

use Enpii_Base\App\Console\Commands\Tinker\Tinker_Command;
use Enpii_Base\Tests\Support\Unit\Libs\Unit_Test_Case;
use Laravel\Tinker\Console\TinkerCommand;

class Tinker_Command_Test extends Unit_Test_Case {

	public function test_handle(): void {
		// Mock the Tinker_Command class
		$tinker_command_mock = $this->getMockBuilder( Tinker_Command::class )
							->disableOriginalConstructor()
							->getMock();

		// Assert that the mock object is an instance of TinkerCommand
		$this->assertInstanceOf( TinkerCommand::class, $tinker_command_mock );
	}
}
