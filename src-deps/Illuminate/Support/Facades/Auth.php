<?php

namespace Enpii_Base\Deps\Illuminate\Support\Facades;

use Laravel\Ui\UiServiceProvider;
use RuntimeException;

/**
 * @method static \Enpii_Base\Deps\Illuminate\Auth\AuthManager extend(string $driver, \Closure $callback)
 * @method static \Enpii_Base\Deps\Illuminate\Auth\AuthManager provider(string $name, \Closure $callback)
 * @method static \Enpii_Base\Deps\Illuminate\Contracts\Auth\Authenticatable loginUsingId(mixed $id, bool $remember = false)
 * @method static \Enpii_Base\Deps\Illuminate\Contracts\Auth\Authenticatable|null user()
 * @method static \Enpii_Base\Deps\Illuminate\Contracts\Auth\Guard|\Enpii_Base\Deps\Illuminate\Contracts\Auth\StatefulGuard guard(string|null $name = null)
 * @method static \Enpii_Base\Deps\Illuminate\Contracts\Auth\UserProvider|null createUserProvider(string $provider = null)
 * @method static \Enpii_Base\Deps\Symfony\Component\HttpFoundation\Response|null onceBasic(string $field = 'email',array $extraConditions = [])
 * @method static bool attempt(array $credentials = [], bool $remember = false)
 * @method static bool check()
 * @method static bool guest()
 * @method static bool once(array $credentials = [])
 * @method static bool onceUsingId(mixed $id)
 * @method static bool validate(array $credentials = [])
 * @method static bool viaRemember()
 * @method static bool|null logoutOtherDevices(string $password, string $attribute = 'password')
 * @method static int|string|null id()
 * @method static void login(\Enpii_Base\Deps\Illuminate\Contracts\Auth\Authenticatable $user, bool $remember = false)
 * @method static void logout()
 * @method static void setUser(\Enpii_Base\Deps\Illuminate\Contracts\Auth\Authenticatable $user)
 * @method static void shouldUse(string $name);
 *
 * @see \Enpii_Base\Deps\Illuminate\Auth\AuthManager
 * @see \Enpii_Base\Deps\Illuminate\Contracts\Auth\Factory
 * @see \Enpii_Base\Deps\Illuminate\Contracts\Auth\Guard
 * @see \Enpii_Base\Deps\Illuminate\Contracts\Auth\StatefulGuard
 */
class Auth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'auth';
    }

    /**
     * Register the typical authentication routes for an application.
     *
     * @param  array  $options
     * @return void
     */
    public static function routes(array $options = [])
    {
        if (! static::$app->providerIsLoaded(UiServiceProvider::class)) {
            throw new RuntimeException('In order to use the Auth::routes() method, please install the laravel/ui package.');
        }

        static::$app->make('router')->auth($options);
    }
}
