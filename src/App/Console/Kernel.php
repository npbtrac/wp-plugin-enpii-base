<?php

declare(strict_types=1);

namespace Enpii_Base\App\Console;

use Enpii_Base\App\Console\Commands\WP_App_Setup_Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel {

	/**
	 * The bootstrap classes for the application.
	 *
	 * @var array
	 */
	protected $bootstrappers = [
		\Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
        \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
        \Illuminate\Foundation\Bootstrap\SetRequestForConsole::class,
        \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
        \Illuminate\Foundation\Bootstrap\BootProviders::class,
	];

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		WP_App_Setup_Command::class,
	];

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
		Artisan::command(
			'wp-app:hello',
			function () {
				$this->comment( 'Hello from wp_app()' );
			}
		)->describe( 'Display an inspiring quote' );
	}
}
