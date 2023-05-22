<?php

namespace Enpii_Base\Deps\Illuminate\Auth\Events;

use Enpii_Base\Deps\Illuminate\Queue\SerializesModels;

class Verified
{
    use SerializesModels;

    /**
     * The verified user.
     *
     * @var \Enpii_Base\Deps\Illuminate\Contracts\Auth\MustVerifyEmail
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Auth\MustVerifyEmail  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
