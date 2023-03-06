<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Queue\Connectors;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Redis\Factory as Redis;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Queue\RedisQueue;

class RedisConnector implements ConnectorInterface
{
    /**
     * The Redis database instance.
     *
     * @var \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Redis\Factory
     */
    protected $redis;

    /**
     * The connection name.
     *
     * @var string
     */
    protected $connection;

    /**
     * Create a new Redis queue connector instance.
     *
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Redis\Factory  $redis
     * @param  string|null  $connection
     * @return void
     */
    public function __construct(Redis $redis, $connection = null)
    {
        $this->redis = $redis;
        $this->connection = $connection;
    }

    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        return new RedisQueue(
            $this->redis, $config['queue'],
            $config['connection'] ?? $this->connection,
            $config['retry_after'] ?? 60,
            $config['block_for'] ?? null
        );
    }
}
