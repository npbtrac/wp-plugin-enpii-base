<?php

declare(strict_types=1);

namespace Enpii_Base\Foundation\Shared\Traits;

/**
 * This trait allow the class to have a singleton static object
 */
trait Static_Instance_Trait {
	protected static $instance = null;

	public static function instance() {
		return static::$instance;
	}
	public static function init_instance($init_object, bool $force = false) {
		if (empty(static::$instance) || $force) {
			static::$instance = $init_object;
		}

		return static::$instance;
	}
}
