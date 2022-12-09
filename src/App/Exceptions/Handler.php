<?php

declare(strict_types=1);

namespace Enpii\Wp_Plugin\Enpii_Base\App\Exceptions;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Exceptions\WhoopsHandler;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Monolog\Handler\HandlerInterface;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpKernel\Exception\HttpException;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
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
	 * @param \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request $request
	 * @param Throwable $exception
	 *
	 * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\JsonResponse|\Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Response|\Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response
	 * @throws Throwable
	 */
	public function render( $request, Throwable $exception ) {
		return parent::render( $request, $exception );
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
	 *
	 * @param  \Throwable  $e
	 * @return string
	 */
	protected function renderExceptionContent( Throwable $e ) {
		try {
			return wp_app_config( 'app.debug' ) && class_exists( Whoops::class )
						? $this->renderExceptionWithWhoops( $e )
						: $this->renderExceptionWithSymfony( $e, wp_app_config( 'app.debug' ) );
		} catch ( Exception $exception ) {
			return $this->renderExceptionWithSymfony( $exception, wp_app_config( 'app.debug' ) );
		}
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
