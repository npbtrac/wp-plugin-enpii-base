<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Providers;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Support\DeferrableProvider;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\MigrationServiceProvider;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\AggregateServiceProvider;

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
