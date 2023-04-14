<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Foundation\Shared;

use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Interfaces\Query_Handler_Inferface;

/**
 * This is the base class for Hook Handlers to be inherited from
 * The goal is to be able to manipulate (add, edit, remove) WordPress hook handlers
 * @package Enpii\WP_Plugin\Enpii_Base\Libs
 * @method \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application get_wp_app()
 */

/**
 *
 * @package Enpii\WP_Plugin\Enpii_Base\Libs
 */
abstract class Base_Query_Handler implements Query_Handler_Inferface {
}
