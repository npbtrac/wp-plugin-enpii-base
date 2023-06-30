<?php

declare(strict_types=1);

namespace Enpii_Base\App\Commands;

use Enpii_Base\App\Http\Controllers\Api\Index_Controller as Api_Index_Controller;
use Enpii_Base\Deps\Illuminate\Support\Facades\Route;
use Enpii_Base\Foundation\Shared\Base_Job_Command;

class Register_Base_WP_App_Api_Routes_Job_Command extends Base_Job_Command {
	public function handle(): void {
		if (wp_app()->is_debug_mode()) {
			// For API
			Route::get( '/', [ Api_Index_Controller::class, 'home' ] );

			// For API with session validation
			Route::group(
				[
					'prefix' => '/wp-admin',
					'middleware' => [
						'wp_user_session_validation',
					],
				],
				function () {
					Route::get( '/', [ Api_Index_Controller::class, 'info' ] );
				}
			);
		}
	}
}
