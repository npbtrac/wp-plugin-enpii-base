<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\App\Http\Controllers\Admin\Main_Controller as Admin_Main_Controller;
use Enpii_Base\App\Http\Controllers\Api\Main_Controller as Api_Main_Controller;
use Enpii_Base\App\Http\Controllers\Main_Controller;
use Enpii_Base\App\Http\Controllers\User_Controller;
use Illuminate\Support\Facades\Route;
use Enpii_Base\Foundation\Shared\Base_Job;
use Enpii_Base\Foundation\Support\Executable_Trait;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

class Register_Base_WP_App_Routes_Job extends Base_Job {
	use Executable_Trait;

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(): void {
		// For Frontend
		Route::get( '/', [ Main_Controller::class, 'index' ] );
		Route::get( '/post', [ Main_Controller::class, 'post' ] );
		Route::get( '/page', [ Main_Controller::class, 'page' ] );

		Route::post( '/users/generate-client-app', [ User_Controller::class, 'generate_client_app' ] )->withoutMiddleware( [ VerifyCsrfToken::class ] )->name( 'users-generate-client-app' );
		Route::get( '/users/generate-client-app', [ User_Controller::class, 'generate_client_app' ] )->withoutMiddleware( [ VerifyCsrfToken::class ] );

		// For Admin
		Route::group(
			[
				'prefix' => '/wp-admin',
				'middleware' => [
					'auth',
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
						Route::get( 'setup', [ Admin_Main_Controller::class, 'setup' ] )->name( 'admin-setup' );
					}
				);
			}
		);

		// For API
		Route::group(
			[
				'prefix' => '/api',
			],
			function () {
				Route::get( '/', [ Api_Main_Controller::class, 'home' ] );
				Route::get( '/info', [ Api_Main_Controller::class, 'info' ] );
			}
		);
	}
}
