<?php

namespace Enpii_Base\Deps\Illuminate\Foundation\Providers;

use Enpii_Base\Deps\Illuminate\Contracts\Support\DeferrableProvider;
use Enpii_Base\Deps\Illuminate\Database\MigrationServiceProvider;
use Enpii_Base\Deps\Illuminate\Support\AggregateServiceProvider;

class ConsoleSupportServiceProvider extends AggregateServiceProvider implements DeferrableProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        ArtisanServiceProvider::class,
        MigrationServiceProvider::class,
        ComposerServiceProvider::class,
    ];
}
