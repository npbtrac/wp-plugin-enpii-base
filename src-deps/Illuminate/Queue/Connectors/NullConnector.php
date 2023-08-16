<?php

namespace Enpii_Base\Deps\Illuminate\Queue\Connectors;

use Enpii_Base\Deps\Illuminate\Queue\NullQueue;

class NullConnector implements ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Enpii_Base\Deps\Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        return new NullQueue;
    }
}
