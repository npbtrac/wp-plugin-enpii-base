<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Queue\Console;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Console\Command;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Cache\Repository as Cache;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\InteractsWithTime;

class RestartCommand extends Command
{
    use InteractsWithTime;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'queue:restart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restart queue worker daemons after their current job';

    /**
     * The cache store implementation.
     *
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * Create a new queue restart command.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Cache\Repository  $cache
     * @return void
     */
    public function __construct(Cache $cache)
    {
        parent::__construct();

        $this->cache = $cache;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->cache->forever('illuminate:queue:restart', $this->currentTime());

        $this->info('Broadcasting queue restart signal.');
    }
}
