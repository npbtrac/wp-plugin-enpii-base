<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Cache;

interface Factory
{
    /**
     * Get a cache store instance by name.
     *
     * @param  string|null  $name
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Cache\Repository
     */
    public function store($name = null);
}
