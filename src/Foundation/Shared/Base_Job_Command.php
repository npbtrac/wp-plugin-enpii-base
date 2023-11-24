<?php

declare(strict_types=1);

namespace Enpii_Base\Foundation\Shared;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * This works as the base one for other Command Handlers to inherit
 * @package Enpii_Base\Foundation\Shared
 */
abstract class Base_Job_Command extends Base_Command {
	use Dispatchable;
}
