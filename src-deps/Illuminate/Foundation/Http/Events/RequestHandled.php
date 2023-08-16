<?php

namespace Enpii_Base\Deps\Illuminate\Foundation\Http\Events;

class RequestHandled
{
    /**
     * The request instance.
     *
     * @var \Enpii_Base\Deps\Illuminate\Http\Request
     */
    public $request;

    /**
     * The response instance.
     *
     * @var \Enpii_Base\Deps\Illuminate\Http\Response
     */
    public $response;

    /**
     * Create a new event instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @param  \Enpii_Base\Deps\Illuminate\Http\Response  $response
     * @return void
     */
    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}
