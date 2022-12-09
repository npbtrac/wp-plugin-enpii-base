<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Cookie\Middleware;

use Closure;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Encryption\DecryptException;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Cookie\CookieValuePrefix;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Cookie;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Request;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response;

class EncryptCookies
{
    /**
     * The encrypter instance.
     *
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Encryption\Encrypter
     */
    protected $encrypter;

    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [];

    /**
     * Indicates if cookies should be serialized.
     *
     * @var bool
     */
    protected static $serialize = false;

    /**
     * Create a new CookieGuard instance.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Encryption\Encrypter  $encrypter
     * @return void
     */
    public function __construct(EncrypterContract $encrypter)
    {
        $this->encrypter = $encrypter;
    }

    /**
     * Disable encryption for the given cookie name(s).
     *
     * @param  string|array  $name
     * @return void
     */
    public function disableFor($name)
    {
        $this->except = array_merge($this->except, (array) $name);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next)
    {
        return $this->encrypt($next($this->decrypt($request)));
    }

    /**
     * Decrypt the cookies on the request.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Request  $request
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Request
     */
    protected function decrypt(Request $request)
    {
        foreach ($request->cookies as $key => $cookie) {
            if ($this->isDisabled($key)) {
                continue;
            }

            try {
                $value = $this->decryptCookie($key, $cookie);

                $hasValidPrefix = strpos($value, CookieValuePrefix::create($key, $this->encrypter->getKey())) === 0;

                $request->cookies->set(
                    $key, $hasValidPrefix ? CookieValuePrefix::remove($value) : null
                );
            } catch (DecryptException $e) {
                $request->cookies->set($key, null);
            }
        }

        return $request;
    }

    /**
     * Decrypt the given cookie and return the value.
     *
     * @param  string  $name
     * @param  string|array  $cookie
     * @return string|array
     */
    protected function decryptCookie($name, $cookie)
    {
        return is_array($cookie)
                        ? $this->decryptArray($cookie)
                        : $this->encrypter->decrypt($cookie, static::serialized($name));
    }

    /**
     * Decrypt an array based cookie.
     *
     * @param  array  $cookie
     * @return array
     */
    protected function decryptArray(array $cookie)
    {
        $decrypted = [];

        foreach ($cookie as $key => $value) {
            if (is_string($value)) {
                $decrypted[$key] = $this->encrypter->decrypt($value, static::serialized($key));
            }
        }

        return $decrypted;
    }

    /**
     * Encrypt the cookies on an outgoing response.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response  $response
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response
     */
    protected function encrypt(Response $response)
    {
        foreach ($response->headers->getCookies() as $cookie) {
            if ($this->isDisabled($cookie->getName())) {
                continue;
            }

            $response->headers->setCookie($this->duplicate(
                $cookie,
                $this->encrypter->encrypt(
                    CookieValuePrefix::create($cookie->getName(), $this->encrypter->getKey()).$cookie->getValue(),
                    static::serialized($cookie->getName())
                )
            ));
        }

        return $response;
    }

    /**
     * Duplicate a cookie with a new value.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Cookie  $cookie
     * @param  mixed  $value
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Cookie
     */
    protected function duplicate(Cookie $cookie, $value)
    {
        return new Cookie(
            $cookie->getName(), $value, $cookie->getExpiresTime(),
            $cookie->getPath(), $cookie->getDomain(), $cookie->isSecure(),
            $cookie->isHttpOnly(), $cookie->isRaw(), $cookie->getSameSite()
        );
    }

    /**
     * Determine whether encryption has been disabled for the given cookie.
     *
     * @param  string  $name
     * @return bool
     */
    public function isDisabled($name)
    {
        return in_array($name, $this->except);
    }

    /**
     * Determine if the cookie contents should be serialized.
     *
     * @param  string  $name
     * @return bool
     */
    public static function serialized($name)
    {
        return static::$serialize;
    }
}
