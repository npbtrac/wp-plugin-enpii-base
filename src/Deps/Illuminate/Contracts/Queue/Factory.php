<?php

namespace Enpii_Base\Deps\Illuminate\Contracts\Queue;

interface Factory
{
    /**
     * Resolve a queue connection instance.
     *
     * @param  string|null  $name
     * @return \Enpii_Base\Deps\Illuminate\Contracts\Queue\Queue
     */
    public function connection($name = null);
}
