<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\App\Http\Controllers\Api\Index_Controller;
use Illuminate\Support\Facades\Route;
use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Jobs\Base_Job;

class Register_Base_WP_Api_Routes_Job extends Base_Job
{
    use Dispatchable_Trait;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        if (wp_app()->is_debug_mode()) {
			// For API
			Route::get( '/', [ Index_Controller::class, 'home' ] );
			Route::get( 'info', [ Index_Controller::class, 'info' ] );

			// For API with session validation
			Route::group(
				[
					'prefix' => '/wp-admin',
					'middleware' => [
						'wp_user_session_validation',
					],
				],
				function () {
					Route::get( '/', [ Index_Controller::class, 'info' ] );
				}
			);
		}
    }
}
