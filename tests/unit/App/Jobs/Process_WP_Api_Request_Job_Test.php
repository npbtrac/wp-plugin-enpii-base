<?php

declare(strict_types=1);

namespace Enpii_Base\Tests\Unit\App\Jobs;

use Enpii_Base\App\Jobs\Process_WP_Api_Request_Job;
use Enpii_Base\Foundation\Shared\Base_Job;
use Enpii_Base\Tests\Support\Unit\Libs\Unit_Test_Case;

class Process_WP_Api_Request_Job_Test extends Unit_Test_Case {

	public function test_handle() {
		$job = \Mockery::mock( Process_WP_Api_Request_Job::class );
		$this->assertInstanceOf( Base_Job::class, $job );
	}
}
