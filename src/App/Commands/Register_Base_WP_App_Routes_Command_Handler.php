<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Commands;

use Enpii\WP_Plugin\Enpii_Base\App\Http\Controllers\Index_Controller;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades\Route;
use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Base_Command_Handler;

class Register_Base_WP_App_Routes_Command_Handler extends Base_Command_Handler {
	public function handle( $command = null ): void {
		Route::get( '/', [ Index_Controller::class, 'home' ] );
		Route::get( '/home', [ Index_Controller::class, 'home' ] );
	}
}
