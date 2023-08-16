<?php

namespace Enpii_Base\Deps\Illuminate\Support\Facades;

use Enpii_Base\Deps\Illuminate\Contracts\Auth\Access\Gate as GateContract;

/**
 * @method static \Enpii_Base\Deps\Illuminate\Auth\Access\Gate guessPolicyNamesUsing(callable $callback)
 * @method static \Enpii_Base\Deps\Illuminate\Auth\Access\Response authorize(string $ability, array|mixed $arguments = [])
 * @method static \Enpii_Base\Deps\Illuminate\Auth\Access\Response inspect(string $ability, array|mixed $arguments = [])
 * @method static \Enpii_Base\Deps\Illuminate\Contracts\Auth\Access\Gate after(callable $callback)
 * @method static \Enpii_Base\Deps\Illuminate\Contracts\Auth\Access\Gate before(callable $callback)
 * @method static \Enpii_Base\Deps\Illuminate\Contracts\Auth\Access\Gate define(string $ability, callable|string $callback)
 * @method static \Enpii_Base\Deps\Illuminate\Contracts\Auth\Access\Gate forUser(\Enpii_Base\Deps\Illuminate\Contracts\Auth\Authenticatable|mixed $user)
 * @method static \Enpii_Base\Deps\Illuminate\Contracts\Auth\Access\Gate policy(string $class, string $policy)
 * @method static array abilities()
 * @method static bool allows(string $ability, array|mixed $arguments = [])
 * @method static bool any(iterable|string $abilities, array|mixed $arguments = [])
 * @method static bool check(iterable|string $abilities, array|mixed $arguments = [])
 * @method static bool denies(string $ability, array|mixed $arguments = [])
 * @method static bool has(string $ability)
 * @method static mixed getPolicyFor(object|string $class)
 * @method static mixed raw(string $ability, array|mixed $arguments = [])
 *
 * @see \Enpii_Base\Deps\Illuminate\Contracts\Auth\Access\Gate
 */
class Gate extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return GateContract::class;
    }
}
