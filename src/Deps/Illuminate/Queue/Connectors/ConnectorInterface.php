<?php

namespace Enpii_Base\Deps\Illuminate\Queue\Connectors;

interface ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Enpii_Base\Deps\Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config);
}
