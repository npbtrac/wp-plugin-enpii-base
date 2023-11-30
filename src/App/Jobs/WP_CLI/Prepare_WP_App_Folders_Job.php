<?php

namespace Enpii_Base\App\Jobs\WP_CLI;

use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Shared\Base_Job;
use WP_CLI;

class Prepare_WP_App_Folders_Job extends Base_Job {

	use Dispatchable_Trait;

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(): void {
		$wp_app_base_path = enpii_base_wp_app_get_base_path();
		enpii_base_wp_app_prepare_folders( $wp_app_base_path );

		WP_CLI::success( 'Preparing needed folders for WP App done!' );
	}
}
