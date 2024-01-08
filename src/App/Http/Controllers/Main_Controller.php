<?php

declare(strict_types=1);

namespace Enpii_Base\App\Http\Controllers;

use Enpii_Base\App\WP\Enpii_Base_WP_Plugin;
use Enpii_Base\Foundation\Http\Base_Controller;
use Illuminate\Support\Facades\Auth;

class Main_Controller extends Base_Controller {
	public function index() {
		return Enpii_Base_WP_Plugin::wp_app_instance()->view(
			'main/index',
			[
				'message' => empty( Auth::user() ) ? 'Hello guest, welcome to WP App home screen' : sprintf( 'Logged-in user is here, username %s, user ID %s', Auth::user()->ID, Auth::user()->user_login ),
			]
		);
	}
}
