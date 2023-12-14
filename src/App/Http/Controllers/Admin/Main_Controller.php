<?php

declare(strict_types=1);

namespace Enpii_Base\App\Http\Controllers\Admin;

use Enpii_Base\App\Support\App_Const;
use Enpii_Base\Foundation\Http\Base_Controller;
use Illuminate\Support\Facades\Artisan;

class Main_Controller extends Base_Controller {
	public function home() {
		return 'Admin';
	}

	/**
	 * @throws \Exception
	 */
	public function setup() {
		do_action( App_Const::ACTION_WP_APP_SETUP_APP );
		return 'Complete Setup';
	}
}
