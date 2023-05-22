<?php

declare(strict_types=1);

namespace Enpii_Base\App\Console;

use Enpii_Base\Deps\Illuminate\Console\Scheduling\Schedule;
use Enpii_Base\Deps\Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
     * The bootstrap classes for the application.
     *
     * @var array
     */
    protected $bootstrappers = [
        \Enpii_Base\Deps\Illuminate\Foundation\Bootstrap\HandleExceptions::class,
        \Enpii_Base\Deps\Illuminate\Foundation\Bootstrap\RegisterFacades::class,
        \Enpii_Base\Deps\Illuminate\Foundation\Bootstrap\SetRequestForConsole::class,
        \Enpii_Base\Deps\Illuminate\Foundation\Bootstrap\RegisterProviders::class,
        \Enpii_Base\Deps\Illuminate\Foundation\Bootstrap\BootProviders::class,
    ];

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
