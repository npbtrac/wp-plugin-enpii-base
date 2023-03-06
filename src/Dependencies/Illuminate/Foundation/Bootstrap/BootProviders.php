<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bootstrap;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application;

class BootProviders
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $app->boot();
    }
}
