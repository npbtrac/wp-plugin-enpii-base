<?php

declare(strict_types=1);

namespace Enpii_Base\App\WP;

use Enpii_Base\App\Providers\Bus_Service_Provider;
use Enpii_Base\App\Providers\Events_Service_Provider;
use Enpii_Base\App\Providers\Log_Service_Provider;
use Enpii_Base\App\Providers\Routing_Service_Provider;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Mix;
use Enpii_Base\Foundation\WP\WP_Plugin_Interface;
use Enpii_Base\Foundation\WP\WP_Theme_Interface;
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
    protected function __construct($basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }

        $this->registerBaseBindings();
		$this->registerBaseServiceProviders();
        $this->registerCoreContainerAliases();
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
		if (!empty($instance)) {
			return $instance;
		}

		static::$config = $config;
		$instance = new static($basePath);
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
				WP_Plugin_Interface::PARAM_KEY_PLUGIN_BASE_URL  => $plugin_base_url,
			]
		);
		$this->instance( $plugin_classsname, $plugin );
		$this->alias( $plugin_classsname, $plugin_slug );
		$this->register( $plugin );
	}

	public function register_theme(
		$theme_classsname,
		$theme_base_path,
		$theme_base_url,
		$parent_theme_base_path = null,
		$parent_theme_base_url = null
	): void {
		$theme = new $theme_classsname( $this );
		if ( ! ( $theme instanceof WP_Theme_Interface ) ) {
			throw new InvalidArgumentException( sprintf( 'The target classname %s must implement %s', $theme_classsname, WP_Theme_Interface::class ) );
		}

		if (get_template_directory() !== get_stylesheet_uri()) {
			$parent_theme_base_path = get_template_directory();
			$parent_theme_base_url = get_template_directory_uri();
		}

		/** @var \Enpii_Base\Libs\WP_Theme $theme  */
		$theme->bind_base_params(
			[
				WP_Theme_Interface::PARAM_KEY_THEME_BASE_PATH => $theme_base_path,
				WP_Theme_Interface::PARAM_KEY_THEME_BASE_URL  => $theme_base_url,
				WP_Theme_Interface::PARAM_KEY_PARENT_THEME_BASE_PATH  => $parent_theme_base_path,
				WP_Theme_Interface::PARAM_KEY_PARENT_THEME_BASE_URL  => $parent_theme_base_url,
			]
		);
		$this->instance( $theme_classsname, $theme );
		$this->register( $theme );
	}

	/**
	 * A shortcut to register actions for enpii_base_wp_app_register_routes
	 * @param mixed $callback
	 * @param int $priority
	 * @param int $accepted_args
	 * @return void
	 */
	public function register_routes($callback, $priority = 10, $accepted_args = 1): void {
		add_action( 'enpii_base_wp_app_register_routes', $callback, $priority, $accepted_args );
	}

	/**
	 * A shortcut to register actions for enpii_base_wp_api_register_routes
	 * @param mixed $callback
	 * @param int $priority
	 * @param int $accepted_args
	 * @return void
	 */
	public function register_api_routes($callback, $priority = 10, $accepted_args = 1): void {
		add_action( 'enpii_base_wp_api_register_routes', $callback, $priority, $accepted_args );
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
		return wp_app_config('app.debug');
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

	// Todo: refactor this using constant
	/**
	 * @inheritedDoc
	 *
	 * @param  string  $path
	 * @return string
	 */
	public function databasePath( $path = '' ) {
		return dirname(dirname( dirname( __DIR__ ) )) . DIRECTORY_SEPARATOR . 'database' . ( $path ? DIRECTORY_SEPARATOR . $path : $path );
	}

	// Todo: refactor this using constant
	/**
	 * @inheritedDoc
	 *
	 * @param  string  $path
	 * @return string
	 */
	public function resourcePath( $path = '' ) {
		return dirname(dirname( dirname( __DIR__ ) )) . DIRECTORY_SEPARATOR . 'resources' . ( $path ? DIRECTORY_SEPARATOR . $path : $path );
	}

	/**
     * Get the application namespace.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function getNamespace()
    {
        if (! is_null($this->namespace)) {
            return $this->namespace;
        }

		return $this->namespace = 'Enpii_Base\\';
    }

	/**
     * @inheritedDoc
     *
     * @return void
     */
    protected function bindPathsInContainer()
    {
        $this->instance('path', $this->path());
        $this->instance('path.base', $this->basePath());
		$this->instance('path.lang', $this->langPath());
        $this->instance('path.config', $this->configPath());
        $this->instance('path.public', $this->publicPath());
        $this->instance('path.storage', $this->storagePath());
        $this->instance('path.database', $this->databasePath());
        $this->instance('path.resources', $this->resourcePath());
        $this->instance('path.bootstrap', $this->bootstrapPath());

		parent::bindPathsInContainer();
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

		$this->instance(WP_Application::class, $this);
        $this->singleton(Mix::class);
    }

	/**
     * @inheritedDoc
     *
     * @return void
     */
    protected function registerBaseServiceProviders() {
        $this->register(new Events_Service_Provider($this));
        $this->register(new Log_Service_Provider($this));
        $this->register(new Routing_Service_Provider($this));
        $this->register(new Bus_Service_Provider($this));
    }
}
