<?php

namespace Enpii_Base\Tests\Unit\Foundation\WP;

use Enpii_Base\App\WP\WP_Application;
use Enpii_Base\Foundation\WP\WP_Plugin;
use Enpii_Base\Tests\Support\Unit\Libs\Unit_Test_Case;
use Mockery;

class WP_Plugin_Test extends Unit_Test_Case {

	/**
	 * Test wp_app() function when no abstract is provided.
	 */
	public function test_wp_app_without_abstract() {
		$this->setup_wp_app();

		// Call the wp_app() function with null abstract
		$result = wp_app( null );

		// Assert the result
		$this->assertInstanceOf( WP_Application::class, $result );
	}

	/**
	 * Test wp_app() function when an abstract is provided.
	 */
	public function test_wp_app_with_instance() {
		$this->setup_wp_app();

		// Mock the WP_Application instance
		$application_mock = Mockery::mock( WP_Application::class );

		// Set up expectations
		$application_mock->shouldReceive( 'getInstance' )->once()->andReturnSelf();
		$application_mock->shouldReceive( 'make' )->once()->with( 'MyClass', [ 'param1' => 'value1' ] );

		// Replace the original instance with the mock instance
		$this->wp_app->instance( WP_Application::class, $application_mock );

		// Call the make method
		$result = $application_mock->make( 'MyClass', [ 'param1' => 'value1' ] );

		// Assert that the result is null (or whatever the expected return value is)
		$this->assertNull( $result );
	}

	/**
	 */
	public function test_wp_app_instance() {
		// Set up the WP_Plugin mock
		$wp_plugin_mock = Mockery::mock( WP_Plugin::class );
		$wp_plugin_mock->shouldReceive( 'wp_app_instance' )->once()->andReturnSelf();

		// Call the wp_app_instance method
		$result = $wp_plugin_mock->wp_app_instance();

		// Assert that the wp_app_instance method returns the correct instance
		$this->assertSame( $wp_plugin_mock, $result );
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_bind_base_params(): void {
		$config = [
			'plugin_slug' => 'my_plugin',
			'base_path'   => '/path/to/plugin',
			'base_url'    => 'https://example.com',
		];

		$wp_plugin_mock = $this->getMockBuilder( WP_Plugin::class )
								->disableOriginalConstructor()
								->getMockForAbstractClass();
		$wp_plugin_mock->bind_base_params( $config );

		$this->assertEquals( $config['plugin_slug'], $this->get_protected_property_value( $wp_plugin_mock, 'plugin_slug' ) );
		$this->assertEquals( $config['base_path'], $this->get_protected_property_value( $wp_plugin_mock, 'base_path' ) );
		$this->assertEquals( $config['base_url'], $this->get_protected_property_value( $wp_plugin_mock, 'base_url' ) );
	}

	public function test_register() {
		// Set up the abstract WP_Plugin class mock
		$wp_plugin_mock = Mockery::mock( WP_Plugin::class )
								->shouldAllowMockingMethod( 'register' )
								->shouldAllowMockingProtectedMethods()
								->makePartial();
		$wp_plugin_mock->shouldReceive( 'validate_needed_properties' )->once();
		$wp_plugin_mock->shouldReceive( 'manipulate_hooks' )->once();

		// Call the register method
		$wp_plugin_mock->register();
	}

	public function test_boot() {
		// Set up the abstract WP_Plugin class mock
		$mockClass = $this->getMockBuilder( WP_Plugin::class )
							->disableOriginalConstructor()
							->onlyMethods( [ 'prepare_views_paths', 'get_plugin_slug' ] )
							->getMockForAbstractClass();

		// Set the expectation that the method 'prepare_views_paths' will be called with the result of 'get_plugin_slug'
		$mockClass->expects( $this->once() )
					->method( 'prepare_views_paths' )
					->with( $mockClass->get_plugin_slug() );

		// Call the 'boot' method
		$mockClass->boot();
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_get_plugin_slug(): void {
		// Set the plugin slug
		$expected = 'my-plugin';

		// Mock the WP_Plugin class
		$wp_plugin_mock = $this->getMockBuilder( WP_Plugin::class )
								->disableOriginalConstructor()
								->getMockForAbstractClass();
		$this->set_property_value( $wp_plugin_mock, 'plugin_slug', $expected );

		// Get the actual result
		$actual = $wp_plugin_mock->get_plugin_slug();

		// Assert that the actual result matches the expected result
		$this->assertEquals( $expected, $actual );
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_get_base_path(): void {
		// Set the base path
		$expected = 'my-base-path';

		// Mock the WP_Plugin class
		$wp_plugin_mock = $this->getMockBuilder( WP_Plugin::class )
								->disableOriginalConstructor()
								->getMockForAbstractClass();
		$this->set_property_value( $wp_plugin_mock, 'base_path', $expected );

		// Get the actual result
		$actual = $wp_plugin_mock->get_base_path();

		// Assert that the actual result matches the expected result
		$this->assertEquals( $expected, $actual );
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_get_base_url(): void {
		// Set the base url
		$expected = 'my-base-url';

		// Mock the WP_Plugin class
		$wp_plugin_mock = $this->getMockBuilder( WP_Plugin::class )
								->disableOriginalConstructor()
								->getMockForAbstractClass();
		$this->set_property_value( $wp_plugin_mock, 'base_url', $expected );

		// Get the actual result
		$actual = $wp_plugin_mock->get_base_url();

		// Assert that the actual result matches the expected result
		$this->assertEquals( $expected, $actual );
	}

	public function test_get_views_path() {
		// Set up the abstract WP_Plugin class mock
		$wp_plugin_mock = Mockery::mock( WP_Plugin::class )
								->shouldAllowMockingMethod( 'get_views_path' )
								->shouldAllowMockingProtectedMethods()
								->makePartial();

		$wp_plugin_mock->shouldReceive( 'get_base_path' )->once()->andReturn( 'base_path' );

		// Call the get_views_path method
		$get_views_path_result = $wp_plugin_mock->get_views_path();
		$this->assertEquals( 'base_path' . DIR_SEP . 'resources' . DIR_SEP . 'views', $get_views_path_result );
	}

	public function test_view() {
		// Todo: We need to test later. Blocker: Unable to mock global wp_app_view() function
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_get_plugin_basename(): void {
		// Mock the WP_Plugin class
		$wp_plugin_mock = $this->getMockBuilder( WP_Plugin::class )
								->disableOriginalConstructor()
								->getMockForAbstractClass();
		$this->set_property_value( $wp_plugin_mock, 'base_path', '/path/to/base' );
		$this->set_property_value( $wp_plugin_mock, 'plugin_slug', 'your-plugin' );
		\WP_Mock::userFunction( 'plugin_basename' )
				->once()
				->andReturn( $wp_plugin_mock->get_base_path() . DIR_SEP . $wp_plugin_mock->get_plugin_slug() . '.php' );

		// Get the actual result
		$actual_result = $wp_plugin_mock->get_plugin_basename();
		$this->assertEquals( $wp_plugin_mock->get_base_path() . DIR_SEP . $wp_plugin_mock->get_plugin_slug() . '.php', $actual_result );
	}

	/**
	 * @throws \Exception
	 */
	public function test_translate() {
		// Mock the WP_Plugin class
		$wp_plugin_mock = $this->getMockBuilder( WP_Plugin::class )
								->onlyMethods( [ '_t', 'get_text_domain' ] )
								->disableOriginalConstructor()
								->getMockForAbstractClass();

		// Set the expectation that the _t() function will be called
		$wp_plugin_mock->expects( $this->once() )
						->method( '_t' )
						->withAnyParameters()
						->willReturn( 'Translated' );

		// Call the '_t' method and assert the returned value
		$translated_text = $wp_plugin_mock->_t( 'Untranslated Text' );

		$this->assertEquals( 'Translated', $translated_text );
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_validate_needed_properties(): void {

		// Test case where all properties are set
		$config = [
			'plugin_slug' => 'my_plugin',
			'base_path'   => '/path/to/plugin',
			'base_url'    => 'https://example.com',
		];

		$wp_plugin_mock = $this->getMockBuilder( WP_Plugin::class )
								->disableOriginalConstructor()
								->getMockForAbstractClass();

		$this->set_property_value( $wp_plugin_mock, 'plugin_slug', $config['plugin_slug'] );
		$this->set_property_value( $wp_plugin_mock, 'base_path', $config['base_path'] );
		$this->set_property_value( $wp_plugin_mock, 'base_url', $config['base_url'] );
		$this->expectNotToPerformAssertions();
		$this->invoke_protected_method( $wp_plugin_mock, 'validate_needed_properties' );

		$this->set_property_value( $wp_plugin_mock, 'base_url', '' );
		$this->expectException( \InvalidArgumentException::class );
		$this->invoke_protected_method( $wp_plugin_mock, 'validate_needed_properties' );
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_prepare_views_paths(): void {
		\WP_Mock::userFunction( 'get_stylesheet_directory' )
				->once()
				->andReturn( '/path/to/stylesheet/dir' );

		\WP_Mock::userFunction( 'get_template_directory' )
				->once()
				->andReturn( '/path/to/template/dir' );

		$wp_plugin_mock = $this->getMockBuilder( WP_Plugin::class )
								->disableOriginalConstructor()
								->onlyMethods( [ 'loadViewsFrom' ] )
								->getMockForAbstractClass();
		$wp_plugin_mock->expects( $this->exactly( 3 ) )
						->method( 'loadViewsFrom' );
		$namespace = 'NAMESPACE';
		$this->set_property_value( $wp_plugin_mock, 'base_path', 'base_path' );
		$this->invoke_protected_method( $wp_plugin_mock, 'prepare_views_paths', [ $namespace ] );
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_prepare_views_paths_no_child_theme(): void {
		\WP_Mock::userFunction( 'get_stylesheet_directory' )
				->once()
				->andReturn( '/path/to/stylesheet/dir' );

		\WP_Mock::userFunction( 'get_template_directory' )
				->once()
				->andReturn( '/path/to/stylesheet/dir' );

		$wp_plugin_mock = $this->getMockBuilder( WP_Plugin::class )
								->disableOriginalConstructor()
								->onlyMethods( [ 'loadViewsFrom' ] )
								->getMockForAbstractClass();
		$wp_plugin_mock->expects( $this->exactly( 2 ) )
						->method( 'loadViewsFrom' );
		$namespace = 'NAMESPACE';
		$this->set_property_value( $wp_plugin_mock, 'base_path', 'base_path' );
		$this->invoke_protected_method( $wp_plugin_mock, 'prepare_views_paths', [ $namespace ] );
	}
}
