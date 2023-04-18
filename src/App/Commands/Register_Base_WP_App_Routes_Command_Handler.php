<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Commands;

use Enpii\WP_Plugin\Enpii_Base\App\Http\Controllers\Admin\Index_Controller as Admin_Index_Controller;
use Enpii\WP_Plugin\Enpii_Base\App\Http\Controllers\Api\Index_Controller as Api_Index_Controller;
use Enpii\WP_Plugin\Enpii_Base\App\Http\Controllers\Index_Controller;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades\Route;
use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Base_Command_Handler;

class Register_Base_WP_App_Routes_Command_Handler extends Base_Command_Handler {
	public function handle( $command = null ): void {
		// For Frontend
		Route::get( '/', [ Index_Controller::class, 'home' ] );
		Route::get( '/home', [ Index_Controller::class, 'home' ] );

		// For API
		Route::group(
			[
				'prefix' => '/wp-admin',
				'middleware' => [
					'wp_user_session_validation',
				],
			],
			function () {
				Route::get( '/', [ Admin_Index_Controller::class, 'home' ] );
			}
		);

		// For API
		Route::group(
			[
				'prefix' => '/api',
			], function () {
				Route::get( '/', [ Api_Index_Controller::class, 'home' ] );
				Route::get( '/info', [ Api_Index_Controller::class, 'info' ] );
			}
		);
	}
}
