<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Filesystem;

interface Factory
{
    /**
     * Get a filesystem implementation.
     *
     * @param  string|null  $name
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Filesystem\Filesystem
     */
    public function disk($name = null);
}
