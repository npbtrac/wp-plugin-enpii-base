<?php

namespace Enpii_Base\Deps\Illuminate\Http\Client;

class RequestException extends HttpClientException
{
    /**
     * The response instance.
     *
     * @var \Enpii_Base\Deps\Illuminate\Http\Client\Response
     */
    public $response;

    /**
     * Create a new exception instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Client\Response  $response
     * @return void
     */
    public function __construct(Response $response)
    {
        parent::__construct("HTTP request returned status code {$response->status()}.", $response->status());

        $this->response = $response;
    }
}
