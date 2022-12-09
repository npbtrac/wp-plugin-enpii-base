<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades;

/**
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\RedirectResponse wp_app_action(string $action, array $parameters = [], int $status = 302, array $headers = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\RedirectResponse away(string $path, int $status = 302, array $headers = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\RedirectResponse back(int $status = 302, array $headers = [], $fallback = false)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\RedirectResponse guest(string $path, int $status = 302, array $headers = [], bool $secure = null)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\RedirectResponse home(int $status = 302)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\RedirectResponse intended(string $default = '/', int $status = 302, array $headers = [], bool $secure = null)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\RedirectResponse refresh(int $status = 302, array $headers = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\RedirectResponse route(string $route, array $parameters = [], int $status = 302, array $headers = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\RedirectResponse secure(string $path, int $status = 302, array $headers = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\RedirectResponse signedRoute(string $name, array $parameters = [], \DateTimeInterface|\DateInterval|int $expiration = null, int $status = 302, array $headers = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\RedirectResponse temporarySignedRoute(string $name, \DateTimeInterface|\DateInterval|int $expiration, array $parameters = [], int $status = 302, array $headers = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\RedirectResponse to(string $path, int $status = 302, array $headers = [], bool $secure = null)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\UrlGenerator getUrlGenerator()
 * @method static void setSession(\Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Session\Store $session)
 *
 * @see \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Redirector
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
