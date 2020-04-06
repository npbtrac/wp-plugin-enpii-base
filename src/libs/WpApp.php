<?php


namespace Enpii\Wp\EnpiiBase\Libs;

use Enpii\Wp\EnpiiBase\App\Helpers\ArrayHelper;
use Enpii\Wp\EnpiiBase\Libs\Traits\ServiceTrait;
use Illuminate\Foundation\Application;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Http\Kernel as ContractHttpKernel;
use Illuminate\Contracts\Console\Kernel as ContractConsoleKernel;
use Enpii\Wp\EnpiiBase\App\Http\Kernel as HttpKernel;
use Enpii\Wp\EnpiiBase\App\Console\Kernel as ConsoleKernel;
use Enpii\Wp\EnpiiBase\App\Exceptions\Handler as AppExceptionHandler;


class WpApp extends Application {
	use ServiceTrait;

	protected $runtimeViewPaths = [];

	/**
	 * WpApp constructor.
	 *
	 * @param null|string $base_path
	 */
	public function __construct( $base_path = null ) {
		parent::__construct( $base_path );
	}

	/**
	 * Initialize Application with config array
	 *
	 * @param null|array $config
	 */
	public function initAppWithConfig( $config = null ) {
		$this->initConfig( $config );

		$this->singleton(
			ContractHttpKernel::class,
			HttpKernel::class
		);

		$this->singleton(
			ContractConsoleKernel::class,
			ConsoleKernel::class
		);

		$this->singleton(
			ExceptionHandler::class,
			AppExceptionHandler::class
		);

		$this->registerConfiguredProviders();
	}

	/**
	 * Initialize config instance for Application from config array
	 *
	 * @param null|array $config
	 */
	public function initConfig( $config = null ) {
		$this->singleton( 'config', function ( $app ) use ( $config ) {
			return new ConfigRepository( $config );
		} );
	}

	/**
	 * @return mixed
	 */
	public static function config() {
		return static::getInstance()->make( 'config' );
	}

	/**
	 * Set the view paths on runtime
	 *
	 * @param array $paths
	 */
	public function setRuntimeViewPaths( Array $paths ) {
		$this->runtimeViewPaths = $paths;
	}

	/**
	 * Get working runtime view paths
	 *
	 * @return array
	 */
	public function getRuntimeViewPaths() {
		return $this->runtimeViewPaths;
	}

	/**
	 * Set up view paths with WordPress child and parent theme paths
	 */
	public static function setWpThemeViewPaths() {
		static::getInstance()->runtimeViewPaths = [ get_stylesheet_directory(), get_template_directory() ];
	}

	/**
	 * Append more paths to current view paths, it's useful when you want to render view files in plugins
	 *
	 * @param array $paths
	 */
	public static function appendViewPaths( Array $paths ) {
		static::getInstance()->runtimeViewPaths .= ArrayHelper::merge( static::getInstance()->runtimeViewPaths, $paths );
	}
}