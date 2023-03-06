<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Libs\Interfaces;

interface WP_Plugin_Interface {
	/**
	 * We want to use this method to register and deregister all hooks and related things to be used in the plugin
	 * @return void
	 */
	public function manipulate_hooks(): void;
}
