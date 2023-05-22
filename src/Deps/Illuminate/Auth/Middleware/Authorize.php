<?php

namespace Enpii_Base\Deps\Illuminate\Auth\Middleware;

use Closure;
use Enpii_Base\Deps\Illuminate\Contracts\Auth\Access\Gate;
use Enpii_Base\Deps\Illuminate\Database\Eloquent\Model;

class Authorize
{
    /**
     * The gate instance.
     *
     * @var \Enpii_Base\Deps\Illuminate\Contracts\Auth\Access\Gate
     */
    protected $gate;

    /**
     * Create a new middleware instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function __construct(Gate $gate)
    {
        $this->gate = $gate;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $ability
     * @param  array|null  ...$models
     * @return mixed
     *
     * @throws \Enpii_Base\Deps\Illuminate\Auth\AuthenticationException
     * @throws \Enpii_Base\Deps\Illuminate\Auth\Access\AuthorizationException
     */
    public function handle($request, Closure $next, $ability, ...$models)
    {
        $this->gate->authorize($ability, $this->getGateArguments($request, $models));

        return $next($request);
    }

    /**
     * Get the arguments parameter for the gate.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @param  array|null  $models
     * @return \Enpii_Base\Deps\Illuminate\Database\Eloquent\Model|array|string
     */
    protected function getGateArguments($request, $models)
    {
        if (is_null($models)) {
            return [];
        }

        return wp_app_collect($models)->map(function ($model) use ($request) {
            return $model instanceof Model ? $model : $this->getModel($request, $model);
        })->all();
    }

    /**
     * Get the model to authorize.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @param  string  $model
     * @return \Enpii_Base\Deps\Illuminate\Database\Eloquent\Model|string
     */
    protected function getModel($request, $model)
    {
        if ($this->isClassName($model)) {
            return trim($model);
        } else {
            return $request->route($model, null) ?:
                ((preg_match("/^['\"](.*)['\"]$/", trim($model), $matches)) ? $matches[1] : null);
        }
    }

    /**
     * Checks if the given string looks like a fully qualified class name.
     *
     * @param  string  $value
     * @return bool
     */
    protected function isClassName($value)
    {
        return strpos($value, '\\') !== false;
    }
}
