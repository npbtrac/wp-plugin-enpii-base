<?php

namespace Enpii_Base\Deps\Illuminate\Contracts\Cache;

interface Factory
{
    /**
     * Get a cache store instance by name.
     *
     * @param  string|null  $name
     * @return \Enpii_Base\Deps\Illuminate\Contracts\Cache\Repository
     */
    public function store($name = null);
}
