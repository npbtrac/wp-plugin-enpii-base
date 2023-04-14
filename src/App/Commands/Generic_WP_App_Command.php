<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Commands;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application;
use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Interfaces\Command_Interface;
use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Traits\Accessor_Set_Get_Has_Trait;
use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Traits\Config_Trait;

/**
 * A generic command to be used whenever you don't want to have to create a command for the handler
 * @package Enpii\WP_Plugin\Enpii_Base\App\Commands
 * @method Application get_wp_app()
 */
class Generic_WP_App_Command implements Command_Interface {
	private Application $wp_app;
	private array $config_data;

	use Config_Trait;
	use Accessor_Set_Get_Has_Trait;

	public function __construct(Application $wp_app)
	{
		$this->wp_app = $wp_app;
	}
}
