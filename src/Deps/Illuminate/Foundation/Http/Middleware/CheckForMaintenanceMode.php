<?php

namespace Enpii_Base\Deps\Illuminate\Foundation\Http\Middleware;

use Closure;
use Enpii_Base\Deps\Illuminate\Contracts\Foundation\Application;
use Enpii_Base\Deps\Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Enpii_Base\Deps\Symfony\Component\HttpFoundation\IpUtils;

class CheckForMaintenanceMode
{
    /**
     * The application implementation.
     *
     * @var \Enpii_Base\Deps\Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The URIs that should be accessible while maintenance mode is enabled.
     *
     * @var array
     */
    protected $except = [];

    /**
     * Create a new middleware instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Enpii_Base\Deps\Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Enpii_Base\Deps\Illuminate\Foundation\Http\Exceptions\MaintenanceModeException
     */
    public function handle($request, Closure $next)
    {
        if ($this->app->isDownForMaintenance()) {
            $data = json_decode(file_get_contents($this->app->storagePath().'/framework/down'), true);

            if (isset($data['allowed']) && IpUtils::checkIp($request->ip(), (array) $data['allowed'])) {
                return $next($request);
            }

            if ($this->inExceptArray($request)) {
                return $next($request);
            }

            throw new MaintenanceModeException($data['time'], $data['retry'], $data['message']);
        }

        return $next($request);
    }

    /**
     * Determine if the request has a URI that should be accessible in maintenance mode.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
