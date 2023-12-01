<?php

declare(strict_types=1);

namespace Enpii_Base\App\Console\Commands;

use Enpii_Base\App\Jobs\Setup_WP_App_In_Console_Job;
use Illuminate\Console\Command;

class WP_App_Setup_Command extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'wp-app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup all needed things for the WP Application';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		Setup_WP_App_In_Console_Job::dispatchSync($this);
	}
}
