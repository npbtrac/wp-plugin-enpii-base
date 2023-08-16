<?php

namespace Enpii_Base\Deps\Illuminate\Database\Events;

class StatementPrepared
{
    /**
     * The database connection instance.
     *
     * @var \Enpii_Base\Deps\Illuminate\Database\Connection
     */
    public $connection;

    /**
     * The PDO statement.
     *
     * @var \PDOStatement
     */
    public $statement;

    /**
     * Create a new event instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Database\Connection  $connection
     * @param  \PDOStatement  $statement
     * @return void
     */
    public function __construct($connection, $statement)
    {
        $this->statement = $statement;
        $this->connection = $connection;
    }
}
