<?php

namespace Enpii_Base\Deps\Illuminate\Http\Middleware;

use Closure;
use Enpii_Base\Deps\Illuminate\Support\Carbon;

class SetCacheHeaders
{
    /**
     * Add cache related HTTP headers.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  $options
     * @return \Enpii_Base\Deps\Symfony\Component\HttpFoundation\Response
     *
     * @throws \InvalidArgumentException
     */
    public function handle($request, Closure $next, $options = [])
    {
        $response = $next($request);

        if (! $request->isMethodCacheable() || ! $response->getContent()) {
            return $response;
        }

        if (is_string($options)) {
            $options = $this->parseOptions($options);
        }

        if (isset($options['etag']) && $options['etag'] === true) {
            $options['etag'] = md5($response->getContent());
        }

        if (isset($options['last_modified'])) {
            if (is_numeric($options['last_modified'])) {
                $options['last_modified'] = Carbon::createFromTimestamp($options['last_modified']);
            } else {
                $options['last_modified'] = Carbon::parse($options['last_modified']);
            }
        }

        $response->setCache($options);
        $response->isNotModified($request);

        return $response;
    }

    /**
     * Parse the given header options.
     *
     * @param  string  $options
     * @return array
     */
    protected function parseOptions($options)
    {
        return wp_app_collect(explode(';', $options))->mapWithKeys(function ($option) {
            $data = explode('=', $option, 2);

            return [$data[0] => $data[1] ?? true];
        })->all();
    }
}
