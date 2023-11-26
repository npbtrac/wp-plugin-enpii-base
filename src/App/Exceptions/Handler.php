<?php

declare(strict_types=1);

namespace Enpii_Base\App\Exceptions;

use Enpii_Base\App\WP\Enpii_Base_WP_Plugin;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Exceptions\WhoopsHandler;
use Illuminate\Http\Request;
use Monolog\Handler\HandlerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;
use Throwable;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];

	/**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpExceptionInterface $e)
    {
        $this->registerErrorViewPaths();

		$view = $this->getHttpExceptionView($e);

		// We want to render the view for errors when on debug mode
		//	and the environment should not be 'production'
        if (
			view()->exists($view)
			&& (!wp_app_config('app.debug') || wp_app_config('app.env') === 'production')
		) {
            return wp_app_response()->view($view, [
                'errors' => new ViewErrorBag,
                'exception' => $e,
            ], $e->getStatusCode(), $e->getHeaders());
        }

        return $this->convertExceptionToResponse($e);
    }

	/**
	 * @inheritedDoc
	 * @param HttpExceptionInterface $e
	 * @return string
	 */
    protected function getHttpExceptionView(HttpExceptionInterface $e)
    {
		return 'enpii-base::errors/error';
    }
}
