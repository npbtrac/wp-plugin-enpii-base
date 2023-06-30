<?php

namespace Enpii_Base\Deps\Illuminate\Foundation\Bootstrap;

use Enpii_Base\Deps\Illuminate\Contracts\Foundation\Application;
use Enpii_Base\Deps\Illuminate\Http\Request;

class SetRequestForConsole
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $uri = $app->make('config')->get('app.url', 'http://localhost');

        $components = parse_url($uri);

        $server = $_SERVER;

        if (isset($components['path'])) {
            $server = array_merge($server, [
                'SCRIPT_FILENAME' => $components['path'],
                'SCRIPT_NAME' => $components['path'],
            ]);
        }

        $app->instance('request', Request::create(
            $uri, 'GET', [], [], [], $server
        ));
    }
}