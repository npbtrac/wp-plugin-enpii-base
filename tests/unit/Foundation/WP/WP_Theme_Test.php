<?php

namespace Enpii_Base\Tests\Unit\Foundation\WP;

use Enpii_Base\App\WP\WP_Application;
use Enpii_Base\Foundation\WP\WP_Theme;
use Enpii_Base\Tests\Support\Unit\Libs\Unit_Test_Case;
use Mockery;

class WP_Theme_Test extends Unit_Test_Case {

	/**
	 * @throws \ReflectionException
	 * @throws \Exception
	 */
	public function test_bind_base_params(): void {
		$config = [
			'base_path'        => '/path/to/theme',
			'base_url'         => 'https://example.com',
			'parent_base_path' => '/path/to/parent',
			'parent_base_url'  => 'https://example.com/parent-base-url',
		];

		$wp_theme_mock = $this->getMockBuilder( WP_Theme::class )
								->disableOriginalConstructor()
								->getMockForAbstractClass();
		$wp_theme_mock->bind_base_params( $config );

		$this->assertEquals( $config['base_path'], $this->get_protected_property_value( $wp_theme_mock, 'base_path' ) );
		$this->assertEquals( $config['base_url'], $this->get_protected_property_value( $wp_theme_mock, 'base_url' ) );
		$this->assertEquals(
			$config['parent_base_path'],
			$this->get_protected_property_value( $wp_theme_mock, 'parent_base_path' )
		);
		$this->assertEquals(
			$config['parent_base_url'],
			$this->get_protected_property_value( $wp_theme_mock, 'parent_base_url' )
		);
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_register() {
		// Create a mock object for $this->app
		$wp_app_mock = $this->getMockBuilder( \stdClass::class )
							->disableOriginalConstructor()
							->addMethods( [ 'instance' ] )
							->getMock();

		// Set the expectations for the mocked method to call instance() at least once
		$wp_app_mock->expects( $this->atLeast( 1 ) )
					->method( 'instance' )
					->with( WP_Theme::class, $this->anything() )
					->willReturn( true );

		$wp_theme_mock = $this->getMockBuilder( WP_Theme::class )
								->disableOriginalConstructor()
								->getMockForAbstractClass();
		$wp_theme_mock->expects( $this->once() )
						->method( 'manipulate_hooks' );
		$this->set_property_value( $wp_theme_mock, 'app', $wp_app_mock );

		// Call the register method
		$wp_theme_mock->register();
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_prepare_views_paths(): void {
		$wp_theme_mock = $this->getMockBuilder( WP_Theme::class )
								->disableOriginalConstructor()
								->setMethods( [ 'loadViewsFrom' ] )
								->getMockForAbstractClass();
		$wp_theme_mock->expects( $this->exactly( 1 ) )
						->method( 'loadViewsFrom' );
		$namespace = 'NAMESPACE';
		$this->set_property_value( $wp_theme_mock, 'base_path', 'base_path' );
		$this->set_property_value( $wp_theme_mock, 'parent_base_path', '' );
		$this->invoke_protected_method( $wp_theme_mock, 'prepare_views_paths', [ $namespace ] );
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_prepare_views_paths_no_parent_base_path(): void {
		$wp_theme_mock = $this->getMockBuilder( WP_Theme::class )
								->disableOriginalConstructor()
								->setMethods( [ 'loadViewsFrom' ] )
								->getMockForAbstractClass();
		$wp_theme_mock->expects( $this->exactly( 2 ) )
						->method( 'loadViewsFrom' );
		$namespace = 'NAMESPACE';
		$this->set_property_value( $wp_theme_mock, 'base_path', 'base_path' );
		$this->set_property_value( $wp_theme_mock, 'parent_base_path', 'parent_base_path' );
		$this->invoke_protected_method( $wp_theme_mock, 'prepare_views_paths', [ $namespace ] );
	}
}
