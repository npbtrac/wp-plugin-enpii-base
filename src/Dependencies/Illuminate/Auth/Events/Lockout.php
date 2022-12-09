<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Auth\Events;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request;

class Lockout
{
    /**
     * The throttled request.
     *
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
