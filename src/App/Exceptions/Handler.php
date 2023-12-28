<?php

declare(strict_types=1);

namespace Enpii_Base\App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

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
	 * @inheritedDoc
	 * @param HttpExceptionInterface $e
	 * @return string
	 */
	protected function getHttpExceptionView( HttpExceptionInterface $e ) {
		return 'enpii-base::errors/error';
	}
}
