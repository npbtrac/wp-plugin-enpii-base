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
			'theme_slug' => 'theme-slug',
			'base_path' => '/path/to/theme',
			'base_url' => 'https://example.com',
			'parent_base_path' => '/path/to/parent',
			'parent_base_url' => 'https://example.com/parent-base-url',
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
		$this->assertEquals(
			$config['theme_slug'],
			$this->get_protected_property_value( $wp_theme_mock, 'theme_slug' )
		);
	}

	/**
	 * @throws \Exception
	 */
	public function test_register() {
		$config = [
			'theme_slug' => 'theme-slug',
			'base_path' => '/path/to/theme',
			'base_url' => 'https://example.com',
			'parent_base_path' => '/path/to/parent',
			'parent_base_url' => 'https://example.com/parent-base-url',
		];

		// Mock the WP_Theme class
		$wp_theme_mock = $this->getMockBuilder( WP_Theme::class )
								->disableOriginalConstructor()
								->getMockForAbstractClass();
		$wp_theme_mock->expects( $this->once() )
						->method( 'manipulate_hooks' );
		$wp_theme_mock->bind_base_params( $config );

		// Call the register method
		$wp_theme_mock->register();
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_get_theme_slug(): void {
		// Set the theme slug
		$expected = 'my-theme';

		// Mock the WP_Theme class
		$wp_theme_mock = $this->getMockBuilder( WP_Theme::class )
								->disableOriginalConstructor()
								->getMockForAbstractClass();
		$this->set_property_value( $wp_theme_mock, 'theme_slug', $expected );

		// Get the actual result
		$actual = $wp_theme_mock->get_theme_slug();

		// Assert that the actual result matches the expected result
		$this->assertEquals( $expected, $actual );
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_get_base_path(): void {
		// Set the theme base path
		$expected = 'my-base-path';

		// Mock the WP_Theme class
		$wp_theme_mock = $this->getMockBuilder( WP_Theme::class )
								->disableOriginalConstructor()
								->getMockForAbstractClass();
		$this->set_property_value( $wp_theme_mock, 'base_path', $expected );

		// Get the actual result
		$actual = $wp_theme_mock->get_base_path();

		// Assert that the actual result matches the expected result
		$this->assertEquals( $expected, $actual );
	}
	/**
	 * @throws \ReflectionException
	 */
	public function test_get_base_url(): void {
		// Set the theme base url
		$expected = 'my-base-url';

		// Mock the WP_Theme class
		$wp_theme_mock = $this->getMockBuilder( WP_Theme::class )
								->disableOriginalConstructor()
								->getMockForAbstractClass();
		$this->set_property_value( $wp_theme_mock, 'base_url', $expected );

		// Get the actual result
		$actual = $wp_theme_mock->get_base_url();

		// Assert that the actual result matches the expected result
		$this->assertEquals( $expected, $actual );
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_get_parent_base_path(): void {
		// Set the theme parent base path
		$expected = 'my-parent-base-path';

		// Mock the WP_Theme class
		$wp_theme_mock = $this->getMockBuilder( WP_Theme::class )
								->disableOriginalConstructor()
								->getMockForAbstractClass();
		$this->set_property_value( $wp_theme_mock, 'parent_base_path', $expected );

		// Get the actual result
		$actual = $wp_theme_mock->get_parent_base_path();

		// Assert that the actual result matches the expected result
		$this->assertEquals( $expected, $actual );
	}
	/**
	 * @throws \ReflectionException
	 */
	public function test_get_parent_base_url(): void {
		// Set the theme parent base url
		$expected = 'my-parent-base-url';

		// Mock the WP_Theme class
		$wp_theme_mock = $this->getMockBuilder( WP_Theme::class )
								->disableOriginalConstructor()
								->getMockForAbstractClass();
		$this->set_property_value( $wp_theme_mock, 'parent_base_url', $expected );

		// Get the actual result
		$actual = $wp_theme_mock->get_parent_base_url();

		// Assert that the actual result matches the expected result
		$this->assertEquals( $expected, $actual );
	}

	public function test_translate() {
		// Mock the WP_Theme class
		$wp_theme_mock = $this->getMockBuilder( WP_Theme::class )
								->onlyMethods( [ '_t', 'get_text_domain' ] )
								->disableOriginalConstructor()
								->getMockForAbstractClass();

		// Set the expectation that the _t() function will be called
		$wp_theme_mock->expects( $this->once() )
						->method( '_t' )
						->withAnyParameters()
						->willReturn( 'Translated' );

		// Call the '_t' method and assert the returned value
		$translated_text = $wp_theme_mock->_t( 'Untranslated Text' );

		$this->assertEquals( 'Translated', $translated_text );
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_validate_needed_properties(): void {

		// Test case where all properties are set
		$config = [
			'theme_slug' => 'theme-slug',
			'base_path' => '/path/to/theme',
			'base_url' => 'https://example.com',
			'parent_base_path' => '/path/to/parent',
			'parent_base_url' => 'https://example.com/parent-base-url',
		];

		$wp_theme_mock = $this->getMockBuilder( WP_Theme::class )
								->disableOriginalConstructor()
								->getMockForAbstractClass();

		$this->set_property_value( $wp_theme_mock, 'theme_slug', $config['theme_slug'] );
		$this->set_property_value( $wp_theme_mock, 'base_path', $config['base_path'] );
		$this->set_property_value( $wp_theme_mock, 'base_url', $config['base_url'] );
		$this->set_property_value( $wp_theme_mock, 'parent_base_path', $config['parent_base_path'] );
		$this->set_property_value( $wp_theme_mock, 'parent_base_url', $config['parent_base_url'] );
		$this->expectNotToPerformAssertions();
		$this->invoke_protected_method( $wp_theme_mock, 'validate_needed_properties' );

		$this->set_property_value( $wp_theme_mock, 'theme_slug', '' );
		$this->expectException( \InvalidArgumentException::class );
		$this->invoke_protected_method( $wp_theme_mock, 'validate_needed_properties' );
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_prepare_views_paths(): void {
		$wp_theme_mock = $this->getMockBuilder( WP_Theme::class )
								->disableOriginalConstructor()
								->onlyMethods( [ 'loadViewsFrom' ] )
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
								->onlyMethods( [ 'loadViewsFrom' ] )
								->getMockForAbstractClass();
		$wp_theme_mock->expects( $this->exactly( 2 ) )
						->method( 'loadViewsFrom' );
		$namespace = 'NAMESPACE';
		$this->set_property_value( $wp_theme_mock, 'base_path', 'base_path' );
		$this->set_property_value( $wp_theme_mock, 'parent_base_path', 'parent_base_path' );
		$this->invoke_protected_method( $wp_theme_mock, 'prepare_views_paths', [ $namespace ] );
	}
}
