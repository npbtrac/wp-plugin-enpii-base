<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bootstrap;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request;

class SetRequestForConsole
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application  $app
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
