<?php

declare(strict_types=1);

namespace Enpii\Wp_Plugin\Enpii_Base\Libs;

use Enpii\Wp_Plugin\Enpii_Base\Libs\Interfaces\Wp_Hook_Handler_Inferface;
use Enpii\Wp_Plugin\Enpii_Base\Support\Traits\Config_Trait;

/**
 * This is the base class for Hook Handlers to be inherited from
 * The goal is to be able to manipulate (add, edit, remove) WordPress hook handlers
 * @package Enpii\Wp_Plugin\Enpii_Base\Libs
 */
class Wp_Base_Hook_Handler implements Wp_Hook_Handler_Inferface {
	use Config_Trait;

	protected $wp_app;

	public function __construct( array $config = [], bool $strict = false ) {
		$this->bind_config( $config, $strict );
	}

	public function get_wp_app(): Wp_Application {
		return $this->wp_app;
	}
}
