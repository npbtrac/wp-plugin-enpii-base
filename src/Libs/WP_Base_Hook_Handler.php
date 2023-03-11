<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Libs;

use Enpii\WP_Plugin\Enpii_Base\Libs\Interfaces\WP_Hook_Handler_Inferface;
use Enpii\WP_Plugin\Enpii_Base\Support\Traits\Config_Trait;

/**
 * This is the base class for Hook Handlers to be inherited from
 * The goal is to be able to manipulate (add, edit, remove) WordPress hook handlers
 * @package Enpii\WP_Plugin\Enpii_Base\Libs
 */
abstract class WP_Base_Hook_Handler implements WP_Hook_Handler_Inferface {
	use Config_Trait;

	protected $wp_app;

	public function __construct( array $config = [], bool $strict = false ) {
		$this->bind_config( $config, $strict );
	}

	public function get_wp_app(): WP_Application {
		return $this->wp_app;
	}
}
