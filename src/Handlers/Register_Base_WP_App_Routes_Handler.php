<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Handlers;

use Enpii\WP_Plugin\Enpii_Base\App\Http\Controllers\Index_Controller;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades\Route;
use Enpii\WP_Plugin\Enpii_Base\Libs\Base_Handler;

class Register_Base_WP_App_Routes_Handler extends Base_Handler {
	public function handle(): void {
		Route::get( '/', [ Index_Controller::class, 'home' ] );
		Route::get( '/home', [ Index_Controller::class, 'home' ] );
	}
}
