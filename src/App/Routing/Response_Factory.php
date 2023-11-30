<?php
declare(strict_types=1);

namespace Enpii_Base\App\Routing;

use Illuminate\Routing\ResponseFactory as BaseResponseFactory;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class Response_Factory extends BaseResponseFactory {
	// /**
	//  * Create a new response instance.
	//  *
	//  * @param  string  $content
	//  * @param  int  $status
	//  * @param  array  $headers
	//  * @return \Enpii_Base\App\Http\Response
	//  */
	// public function make($content = '', $status = 200, array $headers = [])
	// {
	//     return new HttpFoundationResponse($content, $status, $headers);
	// }
}
