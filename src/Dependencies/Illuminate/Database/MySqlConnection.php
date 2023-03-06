<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database;

use Doctrine\DBAL\Driver\PDOMySql\Driver as DoctrineDriver;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Query\Grammars\MySqlGrammar as QueryGrammar;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Query\Processors\MySqlProcessor;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Schema\Grammars\MySqlGrammar as SchemaGrammar;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Schema\MySqlBuilder;

class MySqlConnection extends Connection
{
    /**
     * Get the default query grammar instance.
     *
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Query\Grammars\MySqlGrammar
     */
    protected function getDefaultQueryGrammar()
    {
        return $this->withTablePrefix(new QueryGrammar);
    }

    /**
     * Get a schema builder instance for the connection.
     *
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Schema\MySqlBuilder
     */
    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new MySqlBuilder($this);
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Schema\Grammars\MySqlGrammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new SchemaGrammar);
    }

    /**
     * Get the default post processor instance.
     *
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Query\Processors\MySqlProcessor
     */
    protected function getDefaultPostProcessor()
    {
        return new MySqlProcessor;
    }

    /**
     * Get the Doctrine DBAL driver.
     *
     * @return \Doctrine\DBAL\Driver\PDOMySql\Driver
     */
    protected function getDoctrineDriver()
    {
        return new DoctrineDriver;
    }
}
