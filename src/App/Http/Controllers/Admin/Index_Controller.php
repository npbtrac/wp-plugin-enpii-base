<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Http\Controllers\Admin;

use Enpii\WP_Plugin\Enpii_Base\Foundation\Http\Base_Controller;

class Index_Controller extends Base_Controller {
	public function home() {
		return 'Admin';
	}
}
