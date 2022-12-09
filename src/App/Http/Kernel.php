<?php

declare(strict_types=1);

namespace Enpii\Wp_Plugin\Enpii_Base\App\Http;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * These middleware are run during every request to your application.
	 *
	 * @var array
	 */
	protected $middleware = [];

	/**
	 * The bootstrap classes for the application.
	 *
	 * @var array
	 */
	protected $bootstrappers = [
		\Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bootstrap\HandleExceptions::class,
		\Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bootstrap\RegisterFacades::class,
		\Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bootstrap\RegisterProviders::class,
		\Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bootstrap\BootProviders::class,
	];

	/**
	 * The application's route middleware groups.
	 *
	 * @var array
	 */
	protected $middlewareGroups = [
		'web' => [],
		'api' => [],
	];

	/**
	 * The application's route middleware.
	 *
	 * These middleware may be assigned to groups or used individually.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [];
}
