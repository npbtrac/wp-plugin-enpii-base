<?php

declare(strict_types=1);

namespace Enpii_Base\Foundation\Http;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;

abstract class Base_Controller extends \Illuminate\Routing\Controller {
	public function respond_json($data = [], $status = 200, array $headers = [], $options = 0): JsonResponse
	{
		/** @var \Enpii_Base\App\Routing $response */
		$response = wp_app_response();

		// As Laravel 10 doesn't allow to override the header 'Content-Type'
		//	that might be sent by WordPress previously
		//	so we need to force header for json to be sent here
		header('Content-Type: application/json, utf-8');

		return $response->json($data, $status, $headers, $options);
	}
}
