<?php

namespace Enpii_Base\Deps\Illuminate\Foundation\Console;

use Enpii_Base\Deps\Illuminate\Console\Command;
use Enpii_Base\Deps\Illuminate\Filesystem\Filesystem;

class ConfigClearCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'config:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the configuration cache file';

    /**
     * The filesystem instance.
     *
     * @var \Enpii_Base\Deps\Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new config clear command instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->files->delete($this->laravel->getCachedConfigPath());

        $this->info('Configuration cache cleared!');
    }
}
