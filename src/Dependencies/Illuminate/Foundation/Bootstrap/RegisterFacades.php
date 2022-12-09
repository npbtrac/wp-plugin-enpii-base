<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bootstrap;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\AliasLoader;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\PackageManifest;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades\Facade;

class RegisterFacades
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        Facade::clearResolvedInstances();

        Facade::setFacadeApplication($app);

        AliasLoader::getInstance(array_merge(
            $app->make('config')->get('app.aliases', []),
            $app->make(PackageManifest::class)->aliases()
        ))->register();
    }
}
