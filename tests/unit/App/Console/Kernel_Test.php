<?php

declare(strict_types=1);

namespace Enpii_Base\Tests\Unit\App\Console;

use Enpii_Base\App\Console\Kernel;
use Enpii_Base\Tests\Support\Unit\Libs\Unit_Test_Case;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;
use Mockery;

class Kernel_Test extends Unit_Test_Case {

	/**
	 * @throws \ReflectionException
	 */
	public function test_schedule(): void {
		// Mock the Kernel class
		$kernel = $this->getMockBuilder( Kernel::class )
						->disableOriginalConstructor()
						->getMock();

		// Mock the Schedule class
		$schedule = Mockery::mock( Schedule::class );

		// Set up expectations for the schedule() method
		$schedule->shouldReceive( 'command' )
				->with( 'backup:clean' )
				->andReturnSelf();
		$schedule->shouldReceive( 'daily' )
				->andReturnSelf();
		$schedule->shouldReceive( 'at' )
				->with( '01:00' )
				->andReturnSelf();

		$schedule->shouldReceive( 'command' )
				->with( 'backup:run' )
				->andReturnSelf();
		$schedule->shouldReceive( 'daily' )
				->andReturnSelf();
		$schedule->shouldReceive( 'at' )
				->with( '02:00' )
				->andReturnSelf();

		$schedule->shouldReceive( 'command' )
				->with( 'telescope:prune' )
				->andReturnSelf();
		$schedule->shouldReceive( 'daily' )
				->andReturnSelf();
		$schedule->shouldReceive( 'at' )
				->with( '03:00' )
				->andReturnSelf();

		// Assert that the mock objects and their methods were called as expected
		$this->invoke_method( $kernel, 'schedule', [ $schedule ] );
	}

	/**
	 * @throws \ReflectionException
	 */
	public function testCommands(): void {
		// Mock the Kernel class
		$kernel = $this->getMockBuilder( Kernel::class )
						->disableOriginalConstructor()
						->getMock();

		// Mock the Artisan class
		$artisanMock = Mockery::mock( 'alias:' . Artisan::class );
		// Expect the artisan methods to be called
		$artisanMock->shouldReceive( 'command' )
					->once()
					->andReturnSelf();
		$artisanMock->shouldReceive( 'describe' )
					->once();

		// Call the commands method
		$this->invoke_method( $kernel, 'commands' );
	}
}
