<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\App\Http\Controllers\Admin\Main_Controller as Admin_Main_Controller;
use Enpii_Base\App\Http\Controllers\Api\Main_Controller as Api_Main_Controller;
use Enpii_Base\App\Http\Controllers\Main_Controller;
use Illuminate\Support\Facades\Route;
use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Shared\Base_Job;

class Register_Base_WP_App_Routes_Job extends Base_Job
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
			// For Frontend
			Route::get( '/', [ Main_Controller::class, 'index' ] );
			Route::get( '/post', [ Main_Controller::class, 'post' ] );
			Route::get( '/page', [ Main_Controller::class, 'page' ] );

			// For Admin
			Route::group(
				[
					'prefix' => '/wp-admin',
					'middleware' => [
						'wp_user_session_validation',
					],
				],
				function () {
					Route::get( '/', [ Admin_Main_Controller::class, 'home' ] );
					Route::group(
						[
							'prefix' => '/admin',
							'middleware' => [
								'wp_user_session_is_admin_user_validation',
							],
						],
						function () {
							Route::get( 'setup', [ Admin_Main_Controller::class, 'setup' ] )->name('admin-setup');
						}
					);
				}
			);

			// For API
			Route::group(
				[
					'prefix' => '/api',
				], function () {
					Route::get( '/', [ Api_Main_Controller::class, 'home' ] );
					Route::get( '/info', [ Api_Main_Controller::class, 'info' ] );
				}
			);
		}
    }
}
