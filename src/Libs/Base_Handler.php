<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Libs;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application;
use Enpii\WP_Plugin\Enpii_Base\Libs\Interfaces\Handler_Inferface;
use Enpii\WP_Plugin\Enpii_Base\Support\Traits\Accessor_Set_Get_Has_Trait;
use Enpii\WP_Plugin\Enpii_Base\Support\Traits\Config_Trait;

/**
 * This is the base class for Hook Handlers to be inherited from
 * The goal is to be able to manipulate (add, edit, remove) WordPress hook handlers
 * @package Enpii\WP_Plugin\Enpii_Base\Libs
 * @method \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application get_wp_app()
 */
abstract class Base_Handler implements Handler_Inferface {
}
