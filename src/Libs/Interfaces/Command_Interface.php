<?php

namespace Enpii\WP_Plugin\Enpii_Base\Libs\Interfaces;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application;

interface Command_Interface {
	public function get_wp_app(): Application;
}
