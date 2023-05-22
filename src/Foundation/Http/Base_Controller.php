<?php

declare(strict_types=1);

namespace Enpii_Base\Foundation\Http;

use Enpii_Base\Deps\Illuminate\Foundation\Bus\DispatchesJobs;
use Enpii_Base\Deps\Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Base_Controller extends \Enpii_Base\Deps\Illuminate\Routing\Controller {
	use DispatchesJobs;
	use ValidatesRequests;
}
