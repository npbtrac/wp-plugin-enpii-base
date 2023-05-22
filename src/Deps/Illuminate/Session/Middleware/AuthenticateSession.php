<?php

namespace Enpii_Base\Deps\Illuminate\Session\Middleware;

use Closure;
use Enpii_Base\Deps\Illuminate\Auth\AuthenticationException;
use Enpii_Base\Deps\Illuminate\Contracts\Auth\Factory as AuthFactory;

class AuthenticateSession
{
    /**
     * The authentication factory implementation.
     *
     * @var \Enpii_Base\Deps\Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->hasSession() || ! $request->user()) {
            return $next($request);
        }

        if ($this->auth->viaRemember()) {
            $passwordHash = explode('|', $request->cookies->get($this->auth->getRecallerName()))[2] ?? null;

            if (! $passwordHash || $passwordHash != $request->user()->getAuthPassword()) {
                $this->logout($request);
            }
        }

        if (! $request->session()->has('password_hash')) {
            $this->storePasswordHashInSession($request);
        }

        if ($request->session()->get('password_hash') !== $request->user()->getAuthPassword()) {
            $this->logout($request);
        }

        return tap($next($request), function () use ($request) {
            $this->storePasswordHashInSession($request);
        });
    }

    /**
     * Store the user's current password hash in the session.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @return void
     */
    protected function storePasswordHashInSession($request)
    {
        if (! $request->user()) {
            return;
        }

        $request->session()->put([
            'password_hash' => $request->user()->getAuthPassword(),
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Enpii_Base\Deps\Illuminate\Auth\AuthenticationException
     */
    protected function logout($request)
    {
        $this->auth->logoutCurrentDevice();

        $request->session()->flush();

        throw new AuthenticationException;
    }
}
