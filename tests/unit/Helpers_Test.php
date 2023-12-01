<?php

declare(strict_types=1);

use Enpii_Base\App\WP\WP_Application;
use Enpii_Base\Tests\Support\Unit\Libs\Unit_Test_Case;

class Helpers_Test extends Unit_Test_Case
{
	public function test_enpii_base_get_major_version()
	{
		$version = '1.2.3';
		$result = enpii_base_get_major_version($version);
		$expected = 1;

		$this->assertEquals($expected, $result);

		$version = 'ver10.29.3';
		$result = enpii_base_get_major_version($version);
		$expected = 10;

		$this->assertEquals($expected, $result);
	}

	public function test_enpii_base_setup_wp_app()
	{
		// Mock the apply_filters() function
        $mockConfig = $this->get_wp_app_config();

		WP_Mock::userFunction('home_url')
            ->once()
            ->andReturn('http://enpii-dev.local');

		WP_Mock::userFunction('get_locale')
            ->once()
            ->andReturn('en-us');

		WP_Mock::userFunction('enpii_base_wp_app_prepare_config')
            ->once()
            ->with($mockConfig)
            ->andReturn($mockConfig);

		// Call the function to be tested
		enpii_base_setup_wp_app();

        // Assert that the WP_Application instance has been created
        $this->assertTrue(WP_Application::isset());
	}
}
