<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Shared\Base_Job;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use InvalidArgumentException;

class Setup_WP_App_In_Console_Job extends Base_Job {

	use Dispatchable_Trait;

	protected $console_command;

	public function __construct( $console_command ) {
		if ( ! ( $console_command instanceof Command ) ) {
			throw new InvalidArgumentException( 'It must be a Console Command instance' );
		}
		$this->console_command = $console_command;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(): void {
		/** @var \Illuminate\Console\Command $console_command */
		$console_command = $this->console_command;

		$console_command->comment( 'Publishing Enpii Base Migrations...' );
		$console_command->call(
			'vendor:publish',
			[
				'--tag' => 'enpii-base-migrations',
				'--force' => true,
			]
		);

		$console_command->comment( 'Publishing Enpii Base Assets...' );
		$console_command->call(
			'vendor:publish',
			[
				'--tag' => 'enpii-base-assets',
				'--force' => true,
			]
		);

		$console_command->comment( 'Publishing Telescope Migrations...' );
		$console_command->call(
			'vendor:publish',
			[
				'--tag' => 'telescope-migrations',
				'--force' => true,
			]
		);

		$console_command->comment( 'Publishing Telescope Assets...' );
		$console_command->call(
			'vendor:publish',
			[
				'--tag' => 'telescope-assets',
				'--force' => true,
			]
		);

		$console_command->comment( 'Doing Migrations...' );
		$console_command->call(
			'migrate',
			[
				'--no-interaction' => true,
				'--quiet' => true,
			]
		);

		// We need to cleanup the migrations file in fake base path database folder
		//  for security reason
		$console_command->comment( 'Cleanup migrations rule' );
		$filesystem = new Filesystem();
		$filesystem->cleanDirectory( wp_app()->databasePath( 'migrations' ) );
	}
}
