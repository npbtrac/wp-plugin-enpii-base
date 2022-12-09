<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Auth;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Guard;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\UserProvider;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Traits\Macroable;

class RequestGuard implements Guard
{
    use GuardHelpers, Macroable;

    /**
     * The guard callback.
     *
     * @var callable
     */
    protected $callback;

    /**
     * The request instance.
     *
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new authentication guard.
     *
     * @param  callable  $callback
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\UserProvider|null  $provider
     * @return void
     */
    public function __construct(callable $callback, Request $request, UserProvider $provider = null)
    {
        $this->request = $request;
        $this->callback = $callback;
        $this->provider = $provider;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (! is_null($this->user)) {
            return $this->user;
        }

        return $this->user = call_user_func(
            $this->callback, $this->request, $this->getProvider()
        );
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        return ! is_null((new static(
            $this->callback, $credentials['request'], $this->getProvider()
        ))->user());
    }

    /**
     * Set the current request instance.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }
}
