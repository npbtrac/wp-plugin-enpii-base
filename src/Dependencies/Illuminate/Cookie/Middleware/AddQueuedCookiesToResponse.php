<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Cookie\Middleware;

use Closure;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Cookie\QueueingFactory as CookieJar;

class AddQueuedCookiesToResponse
{
    /**
     * The cookie jar instance.
     *
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Cookie\QueueingFactory
     */
    protected $cookies;

    /**
     * Create a new CookieQueue instance.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Cookie\QueueingFactory  $cookies
     * @return void
     */
    public function __construct(CookieJar $cookies)
    {
        $this->cookies = $cookies;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        foreach ($this->cookies->getQueuedCookies() as $cookie) {
            $response->headers->setCookie($cookie);
        }

        return $response;
    }
}
