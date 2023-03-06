<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bootstrap;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\AliasLoader;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\PackageManifest;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades\Facade;

class RegisterFacades
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application  $app
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
