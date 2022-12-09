<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Queue;

interface Factory
{
    /**
     * Resolve a queue connection instance.
     *
     * @param  string|null  $name
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Queue\Queue
     */
    public function connection($name = null);
}
