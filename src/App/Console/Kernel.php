<?php

declare(strict_types=1);

namespace Enpii\Wp_Plugin\Enpii_Base\App\Console;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Console\Scheduling\Schedule;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule( Schedule $schedule ) {
		$schedule->command( 'backup:clean' )->daily()->at( '01:00' );
		$schedule->command( 'backup:run' )->daily()->at( '02:00' );
		$schedule->command( 'telescope:prune' )->daily()->at( '03:00' );
	}

	/**
	 * Register the commands for the application.
	 *
	 * @return void
	 */
	protected function commands() {
		// $this->load(__DIR__.'/Commands');

		// require wp_app_base_path('routes/console.php');
	}
}
