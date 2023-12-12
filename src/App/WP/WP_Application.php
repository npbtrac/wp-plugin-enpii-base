<?php

declare(strict_types=1);

namespace Enpii_Base\App\WP;

use Enpii_Base\App\Support\App_Const;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Mix;
use Enpii_Base\Foundation\WP\WP_Plugin_Interface;
use Enpii_Base\Foundation\WP\WP_Theme_Interface;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\PackageManifest;
use Illuminate\Foundation\ProviderRepository;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use RuntimeException;
use TypeError;

/**
 * @package Enpii_Base\App\WP
 */
class WP_Application extends Application {
	/**
	 * We override the parent instance for not messing up with other application
	 *
	 * @var static
	 */
	protected static $instance;

	/**
	 * Config array needed for the initialization process
	 * @var array
	 */
	protected static array $config;

	protected string $wp_app_slug = 'wp-app';
	protected string $wp_api_slug = 'wp-api';

	/**
	 * We don't want to have this class publicly initialized
	 *
	 * @param  string|null  $basePath
	 * @return void
	 */
	protected function __construct( $basePath = null ) {
		if ( $basePath ) {
			$this->setBasePath( $basePath );
		}

		$this->registerBaseBindings();
		$this->registerBaseServiceProviders();
		$this->registerCoreContainerAliases();
	}

	/**
	 * @inheritedDoc
	 *
	 * @param  string  $path
	 * @return string
	 */
	public function resourcePath( $path = '' ) {
		// Todo: refactor this using constant
		return dirname( dirname( dirname( __DIR__ ) ) ) . DIRECTORY_SEPARATOR . 'resources' . ( $path ? DIRECTORY_SEPARATOR . $path : $path );
	}

	/**
	 * @inheritedDoc
	 *
	 * @return string
	 *
	 * @throws \RuntimeException
	 */
	public function getNamespace() {
		if ( ! is_null( $this->namespace ) ) {
			return $this->namespace;
		}

		return $this->namespace = 'Enpii_Base\\';
	}

	/**
	 * @inheritDoc
	 */
	public function runningInConsole() {
		if ( $this->isRunningInConsole === null ) {
			if ( strpos( wp_app_request()->getPathInfo(), 'wp-admin/admin/setup' ) !== false && wp_app_request()->get( 'force_app_running_in_console' ) ) {
				$this->isRunningInConsole = true;
			}
		}

		return parent::runningInConsole();
	}

	/**
	 * @inheritDoc
	 */
	public function registerConfiguredProviders() {
		$providers_list = apply_filters(
			App_Const::FILTER_WP_APP_MAIN_SERVICE_PROVIDERS,
			$this->config['app.providers']
		);
		$providers = Collection::make( $providers_list )
						->partition(
							function ( $provider ) {
								return ( strpos( $provider, 'Enpii_Base\\' ) === 0 ) ||
								( strpos( $provider, 'Illuminate\\' ) === 0 );
							}
						);

		$providers->splice( 1, 0, [ $this->make( PackageManifest::class )->providers() ] );

		( new ProviderRepository( $this, new Filesystem(), $this->getCachedServicesPath() ) )
					->load( $providers->collapse()->toArray() );
	}

	/**
	 * We want to use the array to load the config
	 *
	 * @param mixed $config
	 * @return WP_Application
	 * @throws TypeError
	 * @throws \Illuminate\Contracts\Container\BindingResolutionException
	 */
	public static function init_instance_with_config( $basePath = null, $config = null ): self {
		$instance = static::$instance;
		if ( ! empty( $instance ) ) {
			return $instance;
		}

		static::$config = $config;
		$instance = new static( $basePath );
		$instance->wp_app_slug = $config['wp_app_slug'];
		$instance->wp_api_slug = $config['wp_api_slug'];

		static::$instance = $instance;

		return $instance;
	}

	public function register_plugin(
		$plugin_classsname,
		$plugin_slug,
		$plugin_base_path,
		$plugin_base_url
	): void {
		$plugin = new $plugin_classsname( $this );
		if ( ! ( $plugin instanceof WP_Plugin_Interface ) ) {
			throw new InvalidArgumentException( sprintf( 'The target classname %s must implement %s', $plugin_classsname, WP_Plugin_Interface::class ) );
		}

		/** @var \Enpii_Base\Foundation\WP\WP_Plugin $plugin  */
		$plugin->bind_base_params(
			[
				WP_Plugin_Interface::PARAM_KEY_PLUGIN_SLUG => $plugin_slug,
				WP_Plugin_Interface::PARAM_KEY_PLUGIN_BASE_PATH => $plugin_base_path,
				WP_Plugin_Interface::PARAM_KEY_PLUGIN_BASE_URL => $plugin_base_url,
			]
		);
		$this->instance( $plugin_classsname, $plugin );
		$this->alias( $plugin_classsname, 'plugin-' . $plugin_slug );
		$this->register( $plugin );
	}

	public function register_theme(
		$theme_classsname,
		$theme_slug
	): void {
		$theme = new $theme_classsname( $this );
		if ( ! ( $theme instanceof WP_Theme_Interface ) ) {
			throw new InvalidArgumentException( sprintf( 'The target classname %s must implement %s', $theme_classsname, WP_Theme_Interface::class ) );
		}

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

		/** @var \Enpii_Base\Libs\WP_Theme $theme  */
		$theme->bind_base_params(
			[
				WP_Theme_Interface::PARAM_KEY_THEME_SLUG => $theme_slug,
				WP_Theme_Interface::PARAM_KEY_THEME_BASE_PATH => $theme_base_path,
				WP_Theme_Interface::PARAM_KEY_THEME_BASE_URL => $theme_base_url,
				WP_Theme_Interface::PARAM_KEY_PARENT_THEME_BASE_PATH => $parent_theme_base_path,
				WP_Theme_Interface::PARAM_KEY_PARENT_THEME_BASE_URL => $parent_theme_base_url,
			]
		);
		$this->instance( $theme_classsname, $theme );
		$this->alias( $theme_classsname, 'theme-' . $theme_slug );
		$this->register( $theme );
	}

	/**
	 * A shortcut to register actions for enpii_base_wp_app_register_routes
	 * @param mixed $callback
	 * @param int $priority
	 * @param int $accepted_args
	 * @return void
	 */
	public function register_routes( $callback, $priority = 10, $accepted_args = 1 ): void {
		add_action( App_Const::ACTION_WP_APP_REGISTER_ROUTES, $callback, $priority, $accepted_args );
	}

	/**
	 * A shortcut to register actions for enpii_base_wp_api_register_routes
	 * @param mixed $callback
	 * @param int $priority
	 * @param int $accepted_args
	 * @return void
	 */
	public function register_api_routes( $callback, $priority = 10, $accepted_args = 1 ): void {
		add_action( App_Const::ACTION_WP_API_REGISTER_ROUTES, $callback, $priority, $accepted_args );
	}

	/**
	 * Get the slug for wp-app mode
	 * @return string
	 */
	public function get_wp_app_slug(): string {
		return $this->wp_app_slug;
	}

	/**
	 * Get the slug for wp-api mode
	 * @return string
	 */
	public function get_wp_api_slug(): string {
		return $this->wp_api_slug;
	}

	public function is_debug_mode(): bool {
		return wp_app_config( 'app.debug' );
	}

	/**
	 * For checking if the request uri is for 'wp-app'
	 *
	 * @return bool
	 */
	public function is_wp_app_mode(): bool {
		$wp_app_prefix = $this->wp_app_slug;
		$uri = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( $_SERVER['REQUEST_URI'] ) : '/';

		return ( strpos( $uri, '/' . $wp_app_prefix . '/' ) === 0 || $uri === '/' . $wp_app_prefix );
	}

	/**
	 * For checking if the request uri is for 'wp-app'
	 *
	 * @return bool
	 */
	public function is_wp_api_mode(): bool {
		$wp_site_prefix = $this->wp_api_slug;
		$uri = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( $_SERVER['REQUEST_URI'] ) : '/';

		return ( strpos( $uri, '/' . $wp_site_prefix . '/' ) === 0 || $uri === '/' . $wp_site_prefix );
	}

	/**
	 * For checking if the request uri is for 'wp-app'
	 *
	 * @return bool
	 */
	public function is_wp_site_mode(): bool {
		$wp_site_prefix = 'site';
		$uri = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( $_SERVER['REQUEST_URI'] ) : '/';

		return ( strpos( $uri, '/' . $wp_site_prefix . '/' ) === 0 || $uri === '/' . $wp_site_prefix );
	}

	public function get_laravel_major_version() {
		return enpii_base_get_major_version( Application::VERSION );
		return (int) enpii_base_get_major_version( Application::VERSION );
	}

	public function get_composer_folder_name(): string {
		// We only want to have these Watches on Laravel 8+
		if ( version_compare( '8.0.0', Application::VERSION, '>' ) ) {
			return 'vendor-laravel7';
		}

		return 'vendor';
	}

	public function get_composer_path(): string {
		return defined( 'COMPOSER_VENDOR_DIR' ) ? COMPOSER_VENDOR_DIR : dirname( $this->resourcePath() ) . DIR_SEP . $this->get_composer_folder_name();
	}

	public static function isset(): bool {
		return ! is_null( static::$instance );
	}

	/**
	 * @inheritedDoc
	 *
	 * @return void
	 */
	protected function registerBaseBindings() {
		parent::registerBaseBindings();

		// We want to have the `config` service ready to use later on
		$config = static::$config;
		$this->singleton(
			'config',
			function ( $app ) use ( $config ) {
				return new Repository( $config );
			}
		);

		$this->instance( self::class, $this );
		$this->singleton( Mix::class );
	}

	/**
	 * @inheritedDoc
	 *
	 * @return void
	 */
	protected function registerBaseServiceProviders() {
		$providers = [
			\Enpii_Base\App\Providers\Event_Service_Provider::class,
			\Enpii_Base\App\Providers\Log_Service_Provider::class,
			\Enpii_Base\App\Providers\Routing_Service_Provider::class,
			\Enpii_Base\App\Providers\Bus_Service_Provider::class,
		];

		foreach ( $providers as $provider_classname ) {
			$this->register( $provider_classname );
		}
	}
}
