<?php

declare(strict_types=1);

namespace Enpii_Base\App\Providers\Support;

use Enpii_Base\App\Console\Commands\Job_Make_Command;
use Illuminate\Foundation\Providers\ArtisanServiceProvider;

class Artisan_Service_Provider extends ArtisanServiceProvider {
	/**
	 * Register the command.
	 *
	 * @return void
	 */
	protected function registerJobMakeCommand() {
		$this->app->singleton(
			'command.job.make',
			function ( $app ) {
				return new Job_Make_Command( $app['files'] );
			}
		);
	}
}
