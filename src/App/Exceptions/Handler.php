<?php

declare(strict_types=1);

namespace Enpii_Base\App\Exceptions;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Exceptions\WhoopsHandler;
use Illuminate\Http\Request;
use Monolog\Handler\HandlerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Exception;
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

	/** @noinspection PhpFullyQualifiedNameUsageInspection */
	/**
	 * Report or log an exception.
	 *
	 * @param Throwable $exception
	 *
	 * @throws \Exception
	 */
	public function report( Throwable $exception ) {
		parent::report( $exception );
	}

	/** @noinspection PhpFullyQualifiedNameUsageInspection */
	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param Throwable $exception
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
	 * @throws Throwable
	 */
	public function render( $request, Throwable $exception ) {
		return parent::render( $request, $exception );
	}

	/**
     * Register the error template hint paths.
     *
     * @return void
     */
    protected function registerErrorViewPaths()
    {
        View::replaceNamespace('errors', collect(wp_app_config('view.paths'))->map(function ($path) {
            return "{$path}/errors";
        })->push(__DIR__.'/views')->all());
    }

	/**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpExceptionInterface $e)
    {
        $this->registerErrorViewPaths();
		// devdd(wp_app_config('app.debug'));
        if ($view = $this->getHttpExceptionView($e)) {
            try {
                return response()->view($view, [
                    'errors' => new ViewErrorBag,
                    'exception' => $e,
                ], $e->getStatusCode(), $e->getHeaders());
            } catch (Throwable $t) {
				if (!wp_app_config('app.debug')) {
					throw $t;
				}

                $this->report($t);
            }
        }

        return $this->convertExceptionToResponse($e);
    }

	/**
     * Get the response content for the given exception.
     *
     * @param  \Throwable  $e
     * @return string
     */
    protected function renderExceptionContent(Throwable $e)
    {
        try {
            return wp_app_config('app.debug') && wp_app()->has(ExceptionRenderer::class)
                        ? $this->renderExceptionWithCustomRenderer($e)
                        : $this->renderExceptionWithSymfony($e, wp_app_config('app.debug'));
        } catch (Throwable $e) {
            return $this->renderExceptionWithSymfony($e, wp_app_config('app.debug'));
        }
    }

	/**
	 * @inheritedDoc
	 *
	 * @param  Request  $request
	 * @param  \Throwable  $e
	 * @return Response
	 */
	protected function prepareResponse( $request, Throwable $e ) {
		if ( ! $this->isHttpException( $e ) && wp_app_config( 'app.debug' ) ) {
			return $this->toIlluminateResponse( $this->convertExceptionToResponse( $e ), $e );
		}

		if ( ! $this->isHttpException( $e ) ) {
			$e = new HttpException( 500, $e->getMessage() );
		}

		return $this->toIlluminateResponse(
			$this->renderHttpException( $e ),
			$e
		);
	}

	/**
	 * @inheritedDoc
	 * @param HttpExceptionInterface $e
	 * @return string
	 */
    protected function getHttpExceptionView(HttpExceptionInterface $e)
    {
        return "errors/error";
    }

	/**
	 * Get the Whoops handler for the application.
	 *
	 * @return \Whoops\Handler\Handler
	 */
	protected function whoopsHandler() {
		try {
			return wp_app( HandlerInterface::class );
		} catch ( BindingResolutionException $e ) {
			return ( new WhoopsHandler() )->forDebug();
		}
	}
}
