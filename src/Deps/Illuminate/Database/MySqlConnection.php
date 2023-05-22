<?php

namespace Enpii_Base\Deps\Illuminate\Database;

use Doctrine\DBAL\Driver\PDOMySql\Driver as DoctrineDriver;
use Enpii_Base\Deps\Illuminate\Database\Query\Grammars\MySqlGrammar as QueryGrammar;
use Enpii_Base\Deps\Illuminate\Database\Query\Processors\MySqlProcessor;
use Enpii_Base\Deps\Illuminate\Database\Schema\Grammars\MySqlGrammar as SchemaGrammar;
use Enpii_Base\Deps\Illuminate\Database\Schema\MySqlBuilder;

class MySqlConnection extends Connection
{
    /**
     * Get the default query grammar instance.
     *
     * @return \Enpii_Base\Deps\Illuminate\Database\Query\Grammars\MySqlGrammar
     */
    protected function getDefaultQueryGrammar()
    {
        return $this->withTablePrefix(new QueryGrammar);
    }

    /**
     * Get a schema builder instance for the connection.
     *
     * @return \Enpii_Base\Deps\Illuminate\Database\Schema\MySqlBuilder
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
     * @return \Enpii_Base\Deps\Illuminate\Database\Schema\Grammars\MySqlGrammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new SchemaGrammar);
    }

    /**
     * Get the default post processor instance.
     *
     * @return \Enpii_Base\Deps\Illuminate\Database\Query\Processors\MySqlProcessor
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
