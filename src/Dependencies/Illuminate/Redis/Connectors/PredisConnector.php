<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Redis\Connectors;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Redis\Connector;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Redis\Connections\PredisClusterConnection;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Redis\Connections\PredisConnection;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Arr;
use Predis\Client;

class PredisConnector implements Connector
{
    /**
     * Create a new clustered Predis connection.
     *
     * @param  array  $config
     * @param  array  $options
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Redis\Connections\PredisConnection
     */
    public function connect(array $config, array $options)
    {
        $formattedOptions = array_merge(
            ['timeout' => 10.0], $options, Arr::pull($config, 'options', [])
        );

        return new PredisConnection(new Client($config, $formattedOptions));
    }

    /**
     * Create a new clustered Predis connection.
     *
     * @param  array  $config
     * @param  array  $clusterOptions
     * @param  array  $options
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Redis\Connections\PredisClusterConnection
     */
    public function connectToCluster(array $config, array $clusterOptions, array $options)
    {
        $clusterSpecificOptions = Arr::pull($config, 'options', []);

        return new PredisClusterConnection(new Client(array_values($config), array_merge(
            $options, $clusterOptions, $clusterSpecificOptions
        )));
    }
}
