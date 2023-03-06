<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Auth\Events;

class Failed
{
    /**
     * The authentication guard name.
     *
     * @var string
     */
    public $guard;

    /**
     * The user the attempter was trying to authenticate as.
     *
     * @var \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Authenticatable|null
     */
    public $user;

    /**
     * The credentials provided by the attempter.
     *
     * @var array
     */
    public $credentials;

    /**
     * Create a new event instance.
     *
     * @param  string  $guard
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @param  array  $credentials
     * @return void
     */
    public function __construct($guard, $user, $credentials)
    {
        $this->user = $user;
        $this->guard = $guard;
        $this->credentials = $credentials;
    }
}
