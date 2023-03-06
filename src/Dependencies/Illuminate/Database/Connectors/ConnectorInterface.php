<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Connectors;

interface ConnectorInterface
{
    /**
     * Establish a database connection.
     *
     * @param  array  $config
     * @return \PDO
     */
    public function connect(array $config);
}
