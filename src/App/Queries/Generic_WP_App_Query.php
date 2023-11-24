<?php

declare(strict_types=1);

namespace Enpii_Base\App\Queries;

use Illuminate\Contracts\Foundation\Application;
use Enpii_Base\Foundation\Shared\Interfaces\Query_Interface;
use Enpii_Base\Foundation\Shared\Traits\Accessor_Set_Get_Has_Trait;
use Enpii_Base\Foundation\Shared\Traits\Config_Trait;

/**
 * A generic command to be used whenever you don't want to have to create a command for the handler
 * @package Enpii_Base\App\Commands
 * @method Application get_wp_app()
 */
class Generic_WP_App_Query implements Query_Interface {
	private Application $wp_app;
	private array $config_data;

	use Config_Trait;
	use Accessor_Set_Get_Has_Trait;
}
