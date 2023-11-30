<?php

declare(strict_types=1);

namespace Enpii_Base\App\Http\Controllers\Admin;

use Enpii_Base\Foundation\Http\Base_Controller;

class Main_Controller extends Base_Controller {
	public function home() {
		return 'Admin';
	}
}
