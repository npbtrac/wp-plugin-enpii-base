<?php

namespace Enpii_Base\Tests\Support\Unit\Libs;

use Enpii_Base\App\WP\WP_Application;
use Enpii_Base\Tests\Support\Helpers\Test_Utils;
use Enpii_Base\Tests\Support\Unit_Tester;

class Unit_Test_Case extends \Codeception\Test\Unit {
	use Test_Utils;

	// phpcs:ignore PHPCompatibility.Classes.NewTypedProperties.Found
	protected WP_Application $wp_app;
	protected $wp_app_base_path;

	// phpcs:ignore PHPCompatibility.Classes.NewTypedProperties.Found
	protected Unit_Tester $tester;

	// phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore, Generic.CodeAnalysis.UselessOverridingMethod.Found
	protected function _before(): void {
		parent::_before();
	}

	// phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore, Generic.CodeAnalysis.UselessOverridingMethod.Found
	protected function _after(): void {
		parent::_after();
	}

	protected function setup_wp_app() {
		$this->wp_app_base_path = codecept_root_dir();
		$config = $this->get_wp_app_config();
		$this->wp_app = WP_Application::init_instance_with_config(
			$this->wp_app_base_path,
			$config
		);
	}

	protected function get_wp_app_config() {
		return [
			'app' => [],
			'view' => [
				'paths' => [ $this->wp_app_base_path ],
				'compiled' => [ codecept_output_dir() ],
			],
			'env' => 'local',
			'wp_app_slug' => 'wp-app',
			'wp_api_slug' => 'wp-api',
		];
	}
}
