<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Auth\Console;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Console\Command;

class ClearResetsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:clear-resets {name? : The name of the password broker}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush expired password reset tokens';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->laravel['auth.password']->broker($this->argument('name'))->getRepository()->deleteExpired();

        $this->info('Expired reset tokens cleared!');
    }
}
