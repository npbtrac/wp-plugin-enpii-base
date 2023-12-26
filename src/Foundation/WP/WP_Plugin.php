<?php

declare(strict_types=1);

namespace Enpii_Base\Foundation\WP;

use Illuminate\Support\ServiceProvider;
use Enpii_Base\Foundation\Shared\Traits\Config_Trait;
use InvalidArgumentException;

/**
 * This is the base class for plugin to be inherited from
 * We consider each plugin a Laravel Service provider
 * @package \Enpii_Base\App\WP
 * @property \Enpii_Base\App\WP\WP_Application $app
 */
abstract class WP_Plugin extends ServiceProvider implements WP_Plugin_Interface {
	use Config_Trait;

	protected $plugin_slug;
	// phpcs:ignore PHPCompatibility.Classes.NewTypedProperties.Found
	protected $base_path;
	// phpcs:ignore PHPCompatibility.Classes.NewTypedProperties.Found
	protected $base_url;

	/**
	 * Get the wp_app instance of the plugin
	 *
	 * @return static
	 */
	public static function wp_app_instance(): self {
		// We return the wp_app instance of the successor's class
		return wp_app( static::class );
	}

	/**
	 * We want to bind the the base params using an array
	 *
	 * @param array $base_params_arr
	 * @return void
	 * @throws InvalidArgumentException
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

	public function boot() {
		$this->prepare_views_paths( $this->get_plugin_slug() );
	}

	public function get_plugin_slug(): string {
		return $this->plugin_slug;
	}

	public function get_base_path(): string {
		return $this->base_path;
	}

	public function get_base_url(): string {
		return $this->base_url;
	}

	public function get_views_path(): string {
		return $this->get_base_path() . DIR_SEP . 'resources' . DIR_SEP . 'views';
	}

	public function view( $view ) {
		return wp_app_view( $this->get_plugin_slug() . '::' . $view );
	}

	public function get_plugin_basename(): string {
		return plugin_basename( $this->get_base_path() . DIR_SEP . $this->get_plugin_slug() . '.php' );
	}

	/**
	 * Translate a text using the plugin's text domain
	 *
	 * @param mixed $untranslated_text Text to be translated
	 *
	 * @return string Translated tet
	 * @throws \Exception
	 */
	// phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
	public function _t( $untranslated_text ): string {
		// phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText, WordPress.WP.I18n.NonSingularStringLiteralDomain
		return __( $untranslated_text, $this->get_text_domain() );
	}

	/**
	 * @throws \Exception
	 */
	protected function validate_needed_properties(): void {
		foreach ( [ 'plugin_slug', 'base_path', 'base_url' ] as $property ) {
			if ( empty( $this->$property ) ) {
				throw new InvalidArgumentException(
					sprintf(
						'Property %s must be set for %s',
						// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
						$property,
						// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
						get_class( $this )
					)
				);
			}
		}

		if ( ! preg_match( '/^[a-zA-Z0-9_-]+$/i', $this->plugin_slug ) ) {
			throw new InvalidArgumentException(
				sprintf(
					// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped, WordPress.WP.I18n.MissingTranslatorsComment, WordPress.Security.EscapeOutput.ExceptionNotEscaped
					__( 'Property %1$s must be set for %2$s.', 'enpii' ) . ' ' . __( 'Value must contain only alphanumeric characters _ -', 'enpii' ),
					// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
					'plugin_slug',
					// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
					get_class( $this )
				)
			);
		}
	}

	/**
	 * We want to get the views for each plugin by this order: child theme, parent theme, and the plugin it self
	 */
	// phpcs:ignore Universal.NamingConventions.NoReservedKeywordParameterNames.namespaceFound
	protected function prepare_views_paths( $namespace ): void {
		$this->loadViewsFrom(
			realpath(
				get_stylesheet_directory() . DIR_SEP . 'resources' . DIR_SEP . 'views'
				. DIR_SEP . '_plugins' . DIR_SEP . $namespace
			),
			$namespace
		);
		if ( get_template_directory() !== get_stylesheet_directory() ) {
			$this->loadViewsFrom(
				realpath(
					get_template_directory() . DIR_SEP . 'resources' . DIR_SEP . 'views'
					. DIR_SEP . '_plugins' . DIR_SEP . $namespace
				),
				$namespace
			);
		}
		$this->loadViewsFrom(
			realpath( $this->get_base_path() . DIR_SEP . 'resources' . DIR_SEP . 'views' ),
			$namespace
		);
	}
}
