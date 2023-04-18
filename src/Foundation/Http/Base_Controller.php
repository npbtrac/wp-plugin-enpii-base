<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Foundation\Http;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bus\DispatchesJobs;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Base_Controller extends \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Controller {
	use DispatchesJobs;
	use ValidatesRequests;
}
