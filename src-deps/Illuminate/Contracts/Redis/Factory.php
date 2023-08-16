<?php

namespace Enpii_Base\Deps\Illuminate\Contracts\Redis;

interface Factory
{
    /**
     * Get a Redis connection by name.
     *
     * @param  string|null  $name
     * @return \Enpii_Base\Deps\Illuminate\Redis\Connections\Connection
     */
    public function connection($name = null);
}
