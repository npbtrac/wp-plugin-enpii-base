<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Broadcasting;

interface Factory
{
    /**
     * Get a broadcaster implementation by name.
     *
     * @param  string|null  $name
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Broadcasting\Broadcaster
     */
    public function connection($name = null);
}
