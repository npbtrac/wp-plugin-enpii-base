<?php

declare(strict_types=1);

namespace Enpii_Base\App\Providers;

use Enpii_Base\App\Console\Commands\Tinker\Tinker_Command;
use Laravel\Tinker\TinkerServiceProvider;

class Tinker_Service_Provider extends TinkerServiceProvider {
	public function register() {
		$this->before_register();

		$this->app->singleton(
			'command.tinker',
			function () {
				return new Tinker_Command();
			}
		);

		$this->commands( array( 'command.tinker' ) );
	}

	protected function before_register(): void {
		wp_app_config(
			array(
				'tinker' => apply_filters(
					'enpii_base_wp_app_tinker_config',
					$this->get_default_config()
				),
			)
		);
	}

	protected function get_default_config(): array {
		$config = array(
			/*
			|--------------------------------------------------------------------------
			| Console Commands
			|--------------------------------------------------------------------------
			|
			| This option allows you to add additional Artisan commands that should
			| be available within the Tinker environment. Once the command is in
			| this array you may execute the command in Tinker using its name.
			|
			*/

			'commands' => array(
				// App\Console\Commands\ExampleCommand::class,
			),

			/*
			|--------------------------------------------------------------------------
			| Auto Aliased Classes
			|--------------------------------------------------------------------------
			|
			| Tinker will not automatically alias classes in your vendor namespaces
			| but you may explicitly allow a subset of classes to get aliased by
			| adding the names of each of those classes to the following list.
			|
			*/

			'alias' => array(
				//
			),

			/*
			|--------------------------------------------------------------------------
			| Classes That Should Not Be Aliased
			|--------------------------------------------------------------------------
			|
			| Typically, Tinker automatically aliases classes as you require them in
			| Tinker. However, you may wish to never alias certain classes, which
			| you may accomplish by listing the classes in the following array.
			|
			*/

			'dont_alias' => array(
				'App\Nova',
			),

		);

		return $config;
	}
}
