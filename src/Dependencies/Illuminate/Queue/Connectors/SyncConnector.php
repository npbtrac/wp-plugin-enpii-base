<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Queue\Connectors;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Queue\SyncQueue;

class SyncConnector implements ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        return new SyncQueue;
    }
}
