<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Queue\Connectors;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\ConnectionResolverInterface;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Queue\DatabaseQueue;

class DatabaseConnector implements ConnectorInterface
{
    /**
     * Database connections.
     *
     * @var \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\ConnectionResolverInterface
     */
    protected $connections;

    /**
     * Create a new connector instance.
     *
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\ConnectionResolverInterface  $connections
     * @return void
     */
    public function __construct(ConnectionResolverInterface $connections)
    {
        $this->connections = $connections;
    }

    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        return new DatabaseQueue(
            $this->connections->connection($config['connection'] ?? null),
            $config['table'],
            $config['queue'],
            $config['retry_after'] ?? 60
        );
    }
}
