<?php

namespace Enpii_Base\Deps\Illuminate\Support\Facades;

/**
 * @method static \Enpii_Base\Deps\Illuminate\Database\Schema\Builder create(string $table, \Closure $callback)
 * @method static \Enpii_Base\Deps\Illuminate\Database\Schema\Builder disableForeignKeyConstraints()
 * @method static \Enpii_Base\Deps\Illuminate\Database\Schema\Builder drop(string $table)
 * @method static \Enpii_Base\Deps\Illuminate\Database\Schema\Builder dropIfExists(string $table)
 * @method static \Enpii_Base\Deps\Illuminate\Database\Schema\Builder enableForeignKeyConstraints()
 * @method static \Enpii_Base\Deps\Illuminate\Database\Schema\Builder rename(string $from, string $to)
 * @method static \Enpii_Base\Deps\Illuminate\Database\Schema\Builder table(string $table, \Closure $callback)
 * @method static bool hasColumn(string $table, string $column)
 * @method static bool hasColumns(string $table, array $columns)
 * @method static bool hasTable(string $table)
 * @method static void defaultStringLength(int $length)
 * @method static void registerCustomDoctrineType(string $class, string $name, string $type)
 *
 * @see \Enpii_Base\Deps\Illuminate\Database\Schema\Builder
 */
class Schema extends Facade
{
    /**
     * Get a schema builder instance for a connection.
     *
     * @param  string|null  $name
     * @return \Enpii_Base\Deps\Illuminate\Database\Schema\Builder
     */
    public static function connection($name)
    {
        return static::$app['db']->connection($name)->getSchemaBuilder();
    }

    /**
     * Get a schema builder instance for the default connection.
     *
     * @return \Enpii_Base\Deps\Illuminate\Database\Schema\Builder
     */
    protected static function getFacadeAccessor()
    {
        return static::$app['db']->connection()->getSchemaBuilder();
    }
}
