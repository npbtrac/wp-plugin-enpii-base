<?php

namespace Enpii\WP_Plugin\Enpii_Base\Libs;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application;
use Enpii\WP_Plugin\Enpii_Base\Libs\Interfaces\Command_Interface;
use Enpii\WP_Plugin\Enpii_Base\Support\Traits\Config_Trait;

class Generic_Command implements Command_Interface {
	use Config_Trait;

	protected Application $wp_app;

	public function __construct( Application $wp_app, array $config = [] ) {
		$this->wp_app = $wp_app;
	}

	public function get_wp_app(): Application {
		return $this->wp_app;
	}
}
