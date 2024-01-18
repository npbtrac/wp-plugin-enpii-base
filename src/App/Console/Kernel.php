<?php

declare(strict_types=1);

namespace Enpii_Base\App\Console;

use Enpii_Base\App\Console\Commands\WP_App_Setup_Command;
use Enpii_Base\App\Support\App_Const;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel {

	/**
	 * The bootstrap classes for the application.
	 *  As we are loading configurations from memory (array) with WP_Application
	 *  we don't need to load config from files.
	 *  So we exclude `\Illuminate\Foundation\Bootstrap\LoadConfiguration`
	 *
	 * @var array
	 */
	protected $bootstrappers = [
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
		do_action( App_Const::ACTION_WP_APP_SCHEDULE_RUN, $schedule );
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
				$this->comment( 'Hello from Enpii Base wp_app()' );
			}
		)->describe( 'Display a message from Enpii Base plugin' );
	}
}
