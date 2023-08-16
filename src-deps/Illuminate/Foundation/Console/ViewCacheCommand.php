<?php

namespace Enpii_Base\Deps\Illuminate\Foundation\Console;

use Enpii_Base\Deps\Illuminate\Console\Command;
use Enpii_Base\Deps\Illuminate\Support\Collection;
use Enpii_Base\Deps\Symfony\Component\Finder\Finder;
use Enpii_Base\Deps\Symfony\Component\Finder\SplFileInfo;

class ViewCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Compile all of the application's Blade templates";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('view:clear');

        $this->paths()->each(function ($path) {
            $this->compileViews($this->bladeFilesIn([$path]));
        });

        $this->info('Blade templates cached successfully!');
    }

    /**
     * Compile the given view files.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Support\Collection  $views
     * @return void
     */
    protected function compileViews(Collection $views)
    {
        $compiler = $this->laravel['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $views->map(function (SplFileInfo $file) use ($compiler) {
            $compiler->compile($file->getRealPath());
        });
    }

    /**
     * Get the Blade files in the given path.
     *
     * @param  array  $paths
     * @return \Enpii_Base\Deps\Illuminate\Support\Collection
     */
    protected function bladeFilesIn(array $paths)
    {
        return wp_app_collect(
            Finder::create()
                ->in($paths)
                ->exclude('vendor')
                ->name('*.blade.php')
                ->files()
        );
    }

    /**
     * Get all of the possible view paths.
     *
     * @return \Enpii_Base\Deps\Illuminate\Support\Collection
     */
    protected function paths()
    {
        $finder = $this->laravel['view']->getFinder();

        return wp_app_collect($finder->getPaths())->merge(
            wp_app_collect($finder->getHints())->flatten()
        );
    }
}
