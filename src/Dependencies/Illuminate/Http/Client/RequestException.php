<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client;

class RequestException extends HttpClientException
{
    /**
     * The response instance.
     *
     * @var \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\Response
     */
    public $response;

    /**
     * Create a new exception instance.
     *
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\Response  $response
     * @return void
     */
    public function __construct(Response $response)
    {
        parent::__construct("HTTP request returned status code {$response->status()}.", $response->status());

        $this->response = $response;
    }
}
