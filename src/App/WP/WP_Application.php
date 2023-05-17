<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\WP;

use Enpii\WP_Plugin\Enpii_Base\App\Commands\Generic_WP_App_Command;
use Enpii\WP_Plugin\Enpii_Base\App\Providers\Bus_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\App\Providers\Events_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\App\Providers\Log_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\App\Providers\Routing_Service_Provider;
use Enpii\WP_Plugin\Enpii_Base\App\Queries\Generic_WP_App_Query;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Config\Repository;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Application;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Mix;
use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Base_Command_Handler;
use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Base_Query_Handler;
use Enpii\WP_Plugin\Enpii_Base\Foundation\WP\WP_Plugin_Interface;
use Enpii\WP_Plugin\Enpii_Base\Foundation\WP\WP_Theme_Interface;
use InvalidArgumentException;
use TypeError;

/**
 * @package Enpii\WP_Plugin\Enpii_Base\App\WP
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
	 * @throws \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Container\BindingResolutionException
	 */
	public static function init_instance_with_config( $basePath = null, $config = null ): self {
		$instance = static::$instance;
		if (!empty($instance)) {
			return $instance;
		}

		static::$config = $config;
		$instance = new static($basePath);
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

		/** @var \Enpii\WP_Plugin\Enpii_Base\Foundation\WP\WP_Plugin $plugin  */
		$plugin->bind_base_params(
			[
				WP_Plugin_Interface::PARAM_KEY_PLUGIN_SLUG => $plugin_slug,
				WP_Plugin_Interface::PARAM_KEY_PLUGIN_BASE_PATH => $plugin_base_path,
				WP_Plugin_Interface::PARAM_KEY_PLUGIN_BASE_URL  => $plugin_base_url,
			]
		);
		$this->instance( $plugin_classsname, $plugin );
		$this->register( $plugin );
	}

	public function register_theme(
		$theme_classsname,
		$theme_base_path,
		$theme_base_url,
		$child_theme_base_path = null,
		$child_theme_base_url = null
	): void {
		$theme = new $theme_classsname( $this );
		if ( ! ( $theme instanceof WP_Theme_Interface ) ) {
			throw new InvalidArgumentException( sprintf( 'The target classname %s must implement %s', $theme_classsname, WP_Theme_Interface::class ) );
		}

		/** @var \Enpii\WP_Plugin\Enpii_Base\Libs\WP_Theme $theme  */
		$theme->bind_base_params(
			[
				WP_Theme_Interface::PARAM_KEY_THEME_BASE_PATH => $theme_base_path,
				WP_Theme_Interface::PARAM_KEY_THEME_BASE_URL  => $theme_base_url,
				WP_Theme_Interface::PARAM_KEY_CHILD_THEME_BASE_PATH  => $child_theme_base_path,
				WP_Theme_Interface::PARAM_KEY_CHILD_THEME_BASE_URL  => $child_theme_base_url,
			]
		);
		$this->instance( $theme_classsname, $theme );
		$this->register( $theme );
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
