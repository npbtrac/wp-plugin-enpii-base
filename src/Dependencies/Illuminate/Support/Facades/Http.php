<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\Factory;

/**
 * @method static \GuzzleHttp\Promise\PromiseInterface response($body = null, $status = 200, $headers = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\Factory fake($callback = null)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest accept(string $contentType)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest acceptJson()
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest asForm()
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest asJson()
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest asMultipart()
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest attach(string $name, string $contents, string|null $filename = null, array $headers = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest baseUrl(string $url)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest beforeSending(callable $callback)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest bodyFormat(string $format)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest contentType(string $contentType)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest retry(int $times, int $sleep = 0)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest stub(callable $callback)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest timeout(int $seconds)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest withBasicAuth(string $username, string $password)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest withBody(resource|string $content, string $contentType)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest withCookies(array $cookies, string $domain)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest withDigestAuth(string $username, string $password)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest withHeaders(array $headers)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest withOptions(array $options)
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest withToken(string $token, string $type = 'Bearer')
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest withoutRedirecting()
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\PendingRequest withoutVerifying()
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\Response delete(string $url, array $data = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\Response get(string $url, array $query = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\Response head(string $url, array $query = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\Response patch(string $url, array $data = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\Response post(string $url, array $data = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\Response put(string $url, array $data = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\Response send(string $method, string $url, array $options = [])
 * @method static \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\ResponseSequence fakeSequence(string $urlPattern = '*')
 *
 * @see \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Client\Factory
 */
class Http extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}