<?php

namespace Enpii_Base\Deps\Illuminate\Foundation\Bootstrap;

use Enpii_Base\Deps\Illuminate\Contracts\Foundation\Application;

class RegisterProviders
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $app->registerConfiguredProviders();
    }
}
