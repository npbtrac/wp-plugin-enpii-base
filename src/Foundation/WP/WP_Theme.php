<?php

declare(strict_types=1);

namespace Enpii_Base\Foundation\WP;

use Enpii_Base\App\Support\App_Const;
use Enpii_Base\Foundation\Shared\Traits\Config_Trait;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

/**
 * This is the base class for plugin to be inherited from
 * We consider each plugin a Laravel Service provider
 * @package Enpii_Base\Libs
 * @property \Enpii_Base\App\WP\WP_Application $app
 */
abstract class WP_Theme extends ServiceProvider implements WP_Theme_Interface {
	use Config_Trait;

	/**
	 * @property string The slug of the theme, it should be the folder name, we use it for the instance name
	*/
	protected $theme_slug;
	protected $base_path;
	protected $base_url;
	protected $parent_base_path;
	protected $parent_base_url;

	/**
	 * Get the wp_app instance of the plugin
	 *
	 * @return static
	 */
	public static function wp_app_instance(): self {
		// We return the wp_app instance of the successor's class
		return wp_app( static::class );
	}

	public static function init_with_wp_app( string $slug ): WP_Theme_Interface {
		if ( wp_app()->has( static::class ) ) {
			return wp_app( static::class );
		}

		$theme = new static( wp_app() );
		$theme->init_with_needed_params( $slug );

		// Attch the instance to WP Application
		$theme->attach_to_wp_app();

		// We want to handle the hooks first
		$theme->manipulate_hooks();

		return $theme;
	}

	/**
	 * We want to bind the the base params using an array
	 *
	 * @param array $base_params_arr
	 *
	 * @return void
	 * @throws InvalidArgumentException|\Exception
	 */
	public function bind_base_params( array $base_params_arr ): void {
		$this->bind_config( $base_params_arr, true );
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function register() {
		// We need to ensure all needed properties are set
		$this->validate_needed_properties();

		// We want to handle the hooks first
		$this->manipulate_hooks();
	}

	public function get_theme_slug(): string {
		return $this->theme_slug;
	}

	public function get_base_path(): string {
		return $this->base_path;
	}

	public function get_base_url(): string {
		return $this->base_url;
	}

	public function get_parent_base_path(): string {
		return $this->parent_base_path;
	}

	public function get_parent_base_url(): string {
		return $this->parent_base_url;
	}

	/**
	 * Translate a text using the plugin's text domain
	 *
	 * @param string $untranslated_text Text to be translated
	 *
	 * @return string Translated text
	 * @throws \Exception
	 */
	// phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
	public function _t( $untranslated_text ): string {
		// phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText, WordPress.WP.I18n.NonSingularStringLiteralDomain
		return __( $untranslated_text, $this->get_text_domain() );
	}

	/**
	 * Translate a text using the plugin's text domain
	 *
	 * @param string $untranslated_text Text to be translated
	 * @param string $context for the translation
	 *
	 * @return string Translated text
	 * @throws \Exception
	 */
	// phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
	public function _x( $untranslated_text, $context ): string {
		// phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralContext, WordPress.WP.I18n.NonSingularStringLiteralText, WordPress.WP.I18n.NonSingularStringLiteralDomain
		return _x( $untranslated_text, $context, $this->get_text_domain() );
	}

	/**
	 * @throws \Exception
	 */
	protected function validate_needed_properties(): void {
		if ( empty( $this->theme_slug ) || ! preg_match( '/^[a-zA-Z0-9_-]+$/i', $this->theme_slug ) ) {
			throw new InvalidArgumentException(
				sprintf(
				    // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped, WordPress.WP.I18n.MissingTranslatorsComment, WordPress.Security.EscapeOutput.ExceptionNotEscaped
					__( 'Property %1$s must be set for %2$s.', 'enpii' ) . ' ' . __( 'Value must contain only alphanumeric characters _ -', 'enpii' ),
					// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
					'theme_slug',
					// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
					get_class( $this )
				)
			);
		}
	}

	/**
	 * We want to get the views for each plugin by this order: child theme, parent theme, and the plugin it self
	 */
	protected function prepare_views_paths( $theme_namespace ): void {
		$this->loadViewsFrom( realpath( $this->get_base_path() ), $theme_namespace );
		if ( ! empty( $this->get_parent_base_path() ) ) {
			$this->loadViewsFrom( realpath( $this->get_parent_base_path() ), $theme_namespace );
		}
	}

	protected function init_with_needed_params( string $theme_slug ): void {
		if ( get_template_directory() !== get_stylesheet_directory() ) {
			$theme_base_path = get_stylesheet_directory();
			$theme_base_url = get_stylesheet_directory_uri();
			$parent_theme_base_path = get_template_directory();
			$parent_theme_base_url = get_template_directory_uri();
		} else {
			$theme_base_path = get_template_directory();
			$theme_base_url = get_template_directory_uri();
			$parent_theme_base_path = null;
			$parent_theme_base_url = null;
		}

		/** @var \Enpii_Base\Foundation\WP\WP_Theme $theme  */
		$this->bind_base_params(
			[
				WP_Theme_Interface::PARAM_KEY_THEME_SLUG => $theme_slug,
				WP_Theme_Interface::PARAM_KEY_THEME_BASE_PATH => $theme_base_path,
				WP_Theme_Interface::PARAM_KEY_THEME_BASE_URL => $theme_base_url,
				WP_Theme_Interface::PARAM_KEY_PARENT_THEME_BASE_PATH => $parent_theme_base_path,
				WP_Theme_Interface::PARAM_KEY_PARENT_THEME_BASE_URL => $parent_theme_base_url,
			]
		);

		// We need to ensure all needed properties are set
		$this->validate_needed_properties();
	}

	/**
	 * We do needed things to attach and register the theme to WP Application
	 *
	 * @return void
	 * @throws InvalidArgumentException
	 * @throws Exception
	 */
	protected function attach_to_wp_app(): void {
		wp_app()->instance( static::class, $this );
		wp_app()->alias( static::class, 'theme-' . $this->get_theme_slug() );

		// We want to register the WP_Thee after all needed Service Providers
		$theme = $this;
		add_action(
			App_Const::ACTION_WP_APP_REGISTERED,
			function ( $wp_app ) use ( $theme ) {
				/** @var \Enpii_Base\App\WP\WP_Application $wp_app */
				$wp_app->register( $theme );
			}
		);
	}

	/**
	 * We want give info that this theme is activated
	 * @return void
	 * @throws Exception
	 */
	protected function setup_activated_info() {
		Session::push(
			'info',
			sprintf(
				$this->_t( 'Theme <strong>%s</strong> activated' ),
				$this->get_name()
			)
		);
	}

	/**
	 * We want to check if ACF Pro plugin is loaded,
	 *  if not, flash a caution (warning)
	 * @return void
	 * @throws Exception
	 */
	protected function check_acf_pro_plugin() {
		if ( ! class_exists( 'acf_pro' ) ) {
			Session::push(
				'caution',
				sprintf(
					$this->_t( 'This theme needs <strong>%s</strong> to work properly.' ),
					'Plugin ACF Pro'
				)
			);
		}
	}

	/**
	 * We want to check if Enpii Html Components plugin is loaded,
	 *  if not, flash a caution (warning)
	 * @return void
	 * @throws Exception
	 */
	protected function check_enpii_html_components_plugin() {
		if ( ! defined( 'ENPII_HTML_COMPONENTS_VERSION' ) ) {
			Session::push(
				'caution',
				sprintf(
					$this->_t( 'This theme needs <strong>%s</strong> to work properly.' ),
					'Plugin Enpii Html Components'
				)
			);
		}
	}
}
