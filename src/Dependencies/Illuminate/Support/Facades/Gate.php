<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Access\Gate as GateContract;

/**
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Auth\Access\Gate guessPolicyNamesUsing(callable $callback)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Auth\Access\Response authorize(string $ability, array|mixed $arguments = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Auth\Access\Response inspect(string $ability, array|mixed $arguments = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Access\Gate after(callable $callback)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Access\Gate before(callable $callback)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Access\Gate define(string $ability, callable|string $callback)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Access\Gate forUser(\Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Authenticatable|mixed $user)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Access\Gate policy(string $class, string $policy)
 * @method static array abilities()
 * @method static bool allows(string $ability, array|mixed $arguments = [])
 * @method static bool any(iterable|string $abilities, array|mixed $arguments = [])
 * @method static bool check(iterable|string $abilities, array|mixed $arguments = [])
 * @method static bool denies(string $ability, array|mixed $arguments = [])
 * @method static bool has(string $ability)
 * @method static mixed getPolicyFor(object|string $class)
 * @method static mixed raw(string $ability, array|mixed $arguments = [])
 *
 * @see \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Access\Gate
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
