<?php

declare(strict_types=1);

namespace Enpii_Base\App\Http;

use Enpii_Base\Deps\Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * These middleware are run during every request to your application.
	 *
	 * @var array
	 */
	protected $middleware = [
	];

	/**
     * The bootstrap classes for the application.
     *
     * @var array
     */
    protected $bootstrappers = [
        \Enpii_Base\Deps\Illuminate\Foundation\Bootstrap\HandleExceptions::class,
        \Enpii_Base\Deps\Illuminate\Foundation\Bootstrap\RegisterFacades::class,
        \Enpii_Base\Deps\Illuminate\Foundation\Bootstrap\RegisterProviders::class,
        \Enpii_Base\Deps\Illuminate\Foundation\Bootstrap\BootProviders::class,
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
	protected $routeMiddleware = [
		'wp_user_session_validation' => \Enpii_Base\App\Http\Middleware\WP_User_Session_Validation::class,
	];
}
