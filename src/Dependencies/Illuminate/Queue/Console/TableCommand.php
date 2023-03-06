<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Queue\Console;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Console\Command;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Filesystem\Filesystem;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Composer;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Str;

class TableCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'queue:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the queue jobs database table';

    /**
     * The filesystem instance.
     *
     * @var \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * Create a new queue job table command instance.
     *
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Filesystem\Filesystem  $files
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Composer  $composer
     * @return void
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct();

        $this->files = $files;
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $table = $this->laravel['config']['queue.connections.database.table'];

        $this->replaceMigration(
            $this->createBaseMigration($table), $table, Str::studly($table)
        );

        $this->info('Migration created successfully!');

        $this->composer->dumpAutoloads();
    }

    /**
     * Create a base migration file for the table.
     *
     * @param  string  $table
     * @return string
     */
    protected function createBaseMigration($table = 'jobs')
    {
        return $this->laravel['migration.creator']->create(
            'create_'.$table.'_table', $this->laravel->databasePath().'/migrations'
        );
    }

    /**
     * Replace the generated migration with the job table stub.
     *
     * @param  string  $path
     * @param  string  $table
     * @param  string  $tableClassName
     * @return void
     */
    protected function replaceMigration($path, $table, $tableClassName)
    {
        $stub = str_replace(
            ['{{table}}', '{{tableClassName}}'],
            [$table, $tableClassName],
            $this->files->get(__DIR__.'/stubs/jobs.stub')
        );

        $this->files->put($path, $stub);
    }
}
