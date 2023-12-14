<?php

declare(strict_types=1);

namespace Enpii_Base\App\Queries;

use Enpii_Base\Foundation\Shared\Base_Query;
use Enpii_Base\Foundation\Support\Executable_Trait;
use Illuminate\Foundation\Application;

class Get_WP_App_Info extends Base_Query {
	use Executable_Trait;

	public function handle(): array {
		$info = [];
		$info['php_version'] = phpversion();
		$info['wp_version'] = get_bloginfo( 'version' );
		$info['laravel_version'] = Application::VERSION;
		$info['enpii_base_version'] = ENPII_BASE_PLUGIN_VERSION;

		return $info;
	}
}
