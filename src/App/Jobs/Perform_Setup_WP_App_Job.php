<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\Foundation\Shared\Base_Job;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;

class Perform_Setup_WP_App_Job extends Base_Job {
	use Dispatchable;

	public function handle() {
		enpii_base_wp_app_prepare_folders();

		Artisan::call(
			'wp-app:setup',
			[]
		);

		if ( wp_app_config( 'app.debug' ) ) {
			$output = Artisan::output();
			echo( nl2br( esc_html( $output ) ) );
		}
	}
}
