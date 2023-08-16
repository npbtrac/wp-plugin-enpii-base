<?php

namespace Enpii_Base\Deps\Illuminate\Auth\Events;

use Enpii_Base\Deps\Illuminate\Http\Request;

class Lockout
{
    /**
     * The throttled request.
     *
     * @var \Enpii_Base\Deps\Illuminate\Http\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
