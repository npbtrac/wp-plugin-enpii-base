<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Redis;

interface Factory
{
    /**
     * Get a Redis connection by name.
     *
     * @param  string|null  $name
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Redis\Connections\Connection
     */
    public function connection($name = null);
}
