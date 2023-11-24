<?php
declare(strict_types=1);

namespace Enpii_Base\App\Routing;

use Enpii_Base\App\Http\Response;
use Illuminate\Routing\ResponseFactory as BaseResponseFactory;

class Response_Factory extends BaseResponseFactory {
	/**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return \Enpii_Base\App\Http\Response
     */
    public function make($content = '', $status = 200, array $headers = [])
    {
        return new Response($content, $status, $headers);
    }
}
