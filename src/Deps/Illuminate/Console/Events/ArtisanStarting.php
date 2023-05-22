<?php

namespace Enpii_Base\Deps\Illuminate\Console\Events;

class ArtisanStarting
{
    /**
     * The Artisan application instance.
     *
     * @var \Enpii_Base\Deps\Illuminate\Console\Application
     */
    public $artisan;

    /**
     * Create a new event instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Console\Application  $artisan
     * @return void
     */
    public function __construct($artisan)
    {
        $this->artisan = $artisan;
    }
}
