<?php

namespace Enpii_Base\Deps\Illuminate\Support\Facades;

/**
 * @method static \Enpii_Base\Deps\Illuminate\Http\RedirectResponse wp_app_action(string $action, array $parameters = [], int $status = 302, array $headers = [])
 * @method static \Enpii_Base\Deps\Illuminate\Http\RedirectResponse away(string $path, int $status = 302, array $headers = [])
 * @method static \Enpii_Base\Deps\Illuminate\Http\RedirectResponse back(int $status = 302, array $headers = [], $fallback = false)
 * @method static \Enpii_Base\Deps\Illuminate\Http\RedirectResponse guest(string $path, int $status = 302, array $headers = [], bool $secure = null)
 * @method static \Enpii_Base\Deps\Illuminate\Http\RedirectResponse home(int $status = 302)
 * @method static \Enpii_Base\Deps\Illuminate\Http\RedirectResponse intended(string $default = '/', int $status = 302, array $headers = [], bool $secure = null)
 * @method static \Enpii_Base\Deps\Illuminate\Http\RedirectResponse refresh(int $status = 302, array $headers = [])
 * @method static \Enpii_Base\Deps\Illuminate\Http\RedirectResponse route(string $route, array $parameters = [], int $status = 302, array $headers = [])
 * @method static \Enpii_Base\Deps\Illuminate\Http\RedirectResponse secure(string $path, int $status = 302, array $headers = [])
 * @method static \Enpii_Base\Deps\Illuminate\Http\RedirectResponse signedRoute(string $name, array $parameters = [], \DateTimeInterface|\DateInterval|int $expiration = null, int $status = 302, array $headers = [])
 * @method static \Enpii_Base\Deps\Illuminate\Http\RedirectResponse temporarySignedRoute(string $name, \DateTimeInterface|\DateInterval|int $expiration, array $parameters = [], int $status = 302, array $headers = [])
 * @method static \Enpii_Base\Deps\Illuminate\Http\RedirectResponse to(string $path, int $status = 302, array $headers = [], bool $secure = null)
 * @method static \Enpii_Base\Deps\Illuminate\Routing\UrlGenerator getUrlGenerator()
 * @method static void setSession(\Enpii_Base\Deps\Illuminate\Session\Store $session)
 *
 * @see \Enpii_Base\Deps\Illuminate\Routing\Redirector
 */
class Redirect extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'redirect';
    }
}
