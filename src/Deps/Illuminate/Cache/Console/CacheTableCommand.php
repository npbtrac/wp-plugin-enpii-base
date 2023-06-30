<?php

namespace Enpii_Base\Deps\Illuminate\Cache\Console;

use Enpii_Base\Deps\Illuminate\Console\Command;
use Enpii_Base\Deps\Illuminate\Filesystem\Filesystem;
use Enpii_Base\Deps\Illuminate\Support\Composer;

class CacheTableCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cache:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the cache database table';

    /**
     * The filesystem instance.
     *
     * @var \Enpii_Base\Deps\Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var \Enpii_Base\Deps\Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * Create a new cache table command instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Filesystem\Filesystem  $files
     * @param  \Enpii_Base\Deps\Illuminate\Support\Composer  $composer
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

        $this->files->put($fullPath, $this->files->get(__DIR__.'/stubs/cache.stub'));

        $this->info('Migration created successfully!');

        $this->composer->dumpAutoloads();
    }

    /**
     * Create a base migration file for the table.
     *
     * @return string
     */
    protected function createBaseMigration()
    {
        $name = 'create_cache_table';

        $path = $this->laravel->databasePath().'/migrations';

        return $this->laravel['migration.creator']->create($name, $path);
    }
}