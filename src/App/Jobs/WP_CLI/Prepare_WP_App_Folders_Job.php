<?php

namespace Enpii_Base\App\Jobs\WP_CLI;

use Enpii_Base\Foundation\Shared\Base_Job;
use Illuminate\Foundation\Bus\Dispatchable;
use WP_CLI;

class Prepare_WP_App_Folders_Job extends Base_Job {

	use Dispatchable;

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(): void {
		enpii_base_wp_app_prepare_folders( 0755 );

		WP_CLI::success( 'Preparing needed folders for WP App done!' );
	}
}
