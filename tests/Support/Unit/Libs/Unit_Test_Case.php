<?php

namespace Enpii_Base\Tests\Support\Unit\Libs;

use Enpii_Base\Deps\Illuminate\Foundation\Application;
use Enpii_Base\App\WP\WP_Application;

class Unit_Test_Case extends \Codeception\Test\Unit {
	protected WP_Application $wp_app;
	protected $wp_app_base_path;

	protected function setUp(): void {
		\WP_Mock::setUp();
		$this->wp_app_base_path = codecept_root_dir();
		$config = [
			'app' => '../../../../wp-app-config/app.php',
			'env' => 'local',
			'view' => [
				'paths' => [$this->wp_app_base_path],
				'compiled' => [codecept_output_dir()],
			]
		];
		$this->wp_app = (new WP_Application($this->wp_app_base_path))->init_config($config);
	}

	protected function tearDown(): void {
		\WP_Mock::tearDown();
	}
}
