<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Session\Console;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Console\Command;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Filesystem\Filesystem;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Composer;

class SessionTableCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'session:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the session database table';

    /**
     * The filesystem instance.
     *
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * Create a new session table command instance.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Filesystem\Filesystem  $files
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Composer  $composer
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
        $fullPath = $this->createBaseMigration();

        $this->files->put($fullPath, $this->files->get(__DIR__.'/stubs/database.stub'));

        $this->info('Migration created successfully!');

        $this->composer->dumpAutoloads();
    }

    /**
     * Create a base migration file for the session.
     *
     * @return string
     */
    protected function createBaseMigration()
    {
        $name = 'create_sessions_table';

        $path = $this->laravel->databasePath().'/migrations';

        return $this->laravel['migration.creator']->create($name, $path);
    }
}
