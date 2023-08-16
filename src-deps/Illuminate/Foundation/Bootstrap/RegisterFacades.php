<?php

namespace Enpii_Base\Deps\Illuminate\Foundation\Bootstrap;

use Enpii_Base\Deps\Illuminate\Contracts\Foundation\Application;
use Enpii_Base\Deps\Illuminate\Foundation\AliasLoader;
use Enpii_Base\Deps\Illuminate\Foundation\PackageManifest;
use Enpii_Base\Deps\Illuminate\Support\Facades\Facade;

class RegisterFacades
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Foundation\Application  $app
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
