<?php

namespace Enpii_Base\Deps\Illuminate\Auth\Events;

use Enpii_Base\Deps\Illuminate\Queue\SerializesModels;

class OtherDeviceLogout
{
    use SerializesModels;

    /**
     * The authentication guard name.
     *
     * @var string
     */
    public $guard;

    /**
     * The authenticated user.
     *
     * @var \Enpii_Base\Deps\Illuminate\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  string  $guard
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    public function __construct($guard, $user)
    {
        $this->user = $user;
        $this->guard = $guard;
    }
}