<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\App\Http\Controllers\Api\Main_Controller;
use Illuminate\Support\Facades\Route;
use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Shared\Base_Job;

class Register_Base_WP_Api_Routes_Job extends Base_Job {
	use Dispatchable_Trait;

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(): void {
		// For API
		Route::get( '/', [ Main_Controller::class, 'home' ] );
		Route::get( 'info', [ Main_Controller::class, 'info' ] );

		// For API with session validation
		Route::group(
			[
				'prefix' => '/wp-admin',
				'middleware' => [
					'wp_user_session_validation',
				],
			],
			function () {
				Route::get( '/', [ Main_Controller::class, 'info' ] );
			}
		);
	}
}
