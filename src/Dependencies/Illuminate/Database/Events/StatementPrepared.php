<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Events;

class StatementPrepared
{
    /**
     * The database connection instance.
     *
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Connection
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
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Connection  $connection
     * @param  \PDOStatement  $statement
     * @return void
     */
    public function __construct($connection, $statement)
    {
        $this->statement = $statement;
        $this->connection = $connection;
    }
}
