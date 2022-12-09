<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Auth\Middleware;

use Closure;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Factory as AuthFactory;

class AuthenticateWithBasicAuth
{
    /**
     * The guard factory instance.
     *
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @param  string|null  $field
     * @return mixed
     *
     * @throws \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException
     */
    public function handle($request, Closure $next, $guard = null, $field = null)
    {
        $this->auth->guard($guard)->basic($field ?: 'email');

        return $next($request);
    }
}
