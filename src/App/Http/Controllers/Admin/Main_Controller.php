<?php

declare(strict_types=1);

namespace Enpii_Base\App\Http\Controllers\Admin;

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
		enpii_base_wp_app_prepare_folders();

		Artisan::call(
			'wp-app:setup',
			[]
		);
		$output = Artisan::output();
		echo( nl2br( esc_html( $output ) ) );

		return 'Setup';
	}
}
