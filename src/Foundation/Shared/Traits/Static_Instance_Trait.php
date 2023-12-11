<?php

declare(strict_types=1);

namespace Enpii_Base\Foundation\Shared\Traits;

use InvalidArgumentException;

/**
 * This trait allow the class to have a singleton static object
 */
trait Static_Instance_Trait {
	protected static $instance = null;

	public static function instance() {
		return static::$instance;
	}

	public static function init_instance($init_object): void {
		if (empty(static::$instance)) {
			static::$instance = $init_object;
		} else {
			throw new InvalidArgumentException(__('Instact not empty'));
		}
	}
}
