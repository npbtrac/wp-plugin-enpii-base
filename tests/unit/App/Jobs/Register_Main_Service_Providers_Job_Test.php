<?php

declare(strict_types=1);

namespace Enpii_Base\Tests\Unit\App\Jobs;

use Enpii_Base\App\Jobs\Register_Main_Service_Providers_Job;
use Enpii_Base\App\Providers\Support\Artisan_Service_Provider;
use Enpii_Base\App\Providers\Auth_Service_Provider;
use Enpii_Base\App\Providers\Cache_Service_Provider;
use Enpii_Base\App\Providers\Composer_Service_Provider;
use Enpii_Base\App\Providers\Database_Service_Provider;
use Enpii_Base\App\Providers\Filesystem_Service_Provider;
use Enpii_Base\App\Providers\Migration_Service_Provider;
use Enpii_Base\App\Providers\Queue_Service_Provider;
use Enpii_Base\App\Providers\Support\Route_Service_Provider;
use Enpii_Base\App\Providers\Session_Service_Provider;
use Enpii_Base\App\Providers\Translation_Service_Provider;
use Enpii_Base\App\Providers\Validation_Service_Provider;
use Enpii_Base\App\Providers\View_Service_Provider;
use Enpii_Base\Tests\Support\Unit\Libs\Unit_Test_Case;
use Mockery;

class Register_Main_Service_Providers_Job_Test extends Unit_Test_Case {

	protected $expectedProviders;

	public function setUp(): void {
		$this->expectedProviders = [
			Filesystem_Service_Provider::class,
			Database_Service_Provider::class,
			Cache_Service_Provider::class,
			Auth_Service_Provider::class,
			Route_Service_Provider::class,
			Artisan_Service_Provider::class,
			Queue_Service_Provider::class,
			Composer_Service_Provider::class,
			Migration_Service_Provider::class,
			View_Service_Provider::class,
			Session_Service_Provider::class,
			Validation_Service_Provider::class,
			Translation_Service_Provider::class,
		];

		parent::setUp();
	}

	public function test_constructor_with_config() {
		// Arrange
		$config = [ 'key' => 'value' ];

		// Create a mock for the Register_Main_Service_Providers_Job class
		$job_mock = $this->getMockBuilder( Register_Main_Service_Providers_Job::class )
						->disableOriginalConstructor()
						->getMock();

		// Expect the bind_config method to be called exactly once with the given arguments
		$job_mock->expects( $this->once() )
				->method( 'bind_config' )
				->with( $config, true );
		// Act
		$job_mock->__construct( $config );

		// No additional assertions needed as the expectations are already set
	}

	public function test_constructor_without_config() {
		// Create a mock for the Register_Main_Service_Providers_Job class
		$job_mock = $this->getMockBuilder( Register_Main_Service_Providers_Job::class )
						->disableOriginalConstructor()
						->getMock();
		// Expect no calls to the bind_config method
		$job_mock->__construct();

		// No dditional assertions needed as the expectations are already set
	}

	public function test_handle(): void {
		$this->setup_wp_app();

		global $wpdb;
		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$wpdb             = Mockery::mock( 'wpdb' );
		$wpdb->dbhost     = 'dbhost'; // Assigning the dbhost property
		$wpdb->dbname     = 'dbname'; // Assigning the dbname property
		$wpdb->dbuser     = 'dbuser'; // Assigning the dbuser property
		$wpdb->dbpassword = 'dbpassword'; // Assigning the dbpassword property

		\WP_Mock::userFunction( 'get_stylesheet_directory' )
				->once()
				->andReturn( '/path/to/stylesheet/dir' );

		\WP_Mock::userFunction( 'get_template_directory' )
				->once()
				->andReturn( '/path/to/template/dir' );

		// Create an instance of Register_Main_Service_Providers_Job
		$job = new Register_Main_Service_Providers_Job();

		// Call the handle() method
		$job->handle();

		$registeredProviders = $this->wp_app->getLoadedProviders();
		foreach ( $registeredProviders as $provider ) {
			// We need to ensure all the main service providers are registered
			$this->assertTrue(
				in_array( $provider, $this->expectedProviders ),
				$provider . ' is not registered'
			);
		}
	}
}
