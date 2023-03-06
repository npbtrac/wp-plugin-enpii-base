<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Exceptions;

use RuntimeException;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response;

class HttpResponseException extends RuntimeException
{
    /**
     * The underlying response instance.
     *
     * @var \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response
     */
    protected $response;

    /**
     * Create a new HTTP response exception instance.
     *
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response  $response
     * @return void
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Get the underlying response instance.
     *
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
