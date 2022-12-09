<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Middleware;

use Closure;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Routing\Registrar;

class SubstituteBindings
{
    /**
     * The router instance.
     *
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Routing\Registrar
     */
    protected $router;

    /**
     * Create a new bindings substitutor.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Routing\Registrar  $router
     * @return void
     */
    public function __construct(Registrar $router)
    {
        $this->router = $router;
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
        $this->router->substituteBindings($route = $request->route());

        $this->router->substituteImplicitBindings($route);

        return $next($request);
    }
}
