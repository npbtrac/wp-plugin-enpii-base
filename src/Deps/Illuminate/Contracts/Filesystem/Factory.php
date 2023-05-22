<?php

namespace Enpii_Base\Deps\Illuminate\Contracts\Filesystem;

interface Factory
{
    /**
     * Get a filesystem implementation.
     *
     * @param  string|null  $name
     * @return \Enpii_Base\Deps\Illuminate\Contracts\Filesystem\Filesystem
     */
    public function disk($name = null);
}
