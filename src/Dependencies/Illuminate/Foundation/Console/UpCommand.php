<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Console;

use Exception;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Console\Command;

class UpCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'up';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bring the application out of maintenance mode';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            if (! file_exists(wp_app_storage_path('framework/down'))) {
                $this->comment('Application is already up.');

                return true;
            }

            unlink(wp_app_storage_path('framework/down'));

            $this->info('Application is now live.');
        } catch (Exception $e) {
            $this->error('Failed to disable maintenance mode.');

            $this->error($e->getMessage());

            return 1;
        }
    }
}
