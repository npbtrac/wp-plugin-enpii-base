<?php

declare(strict_types=1);

namespace Enpii_Base\Foundation\Shared;

use Enpii_Base\Deps\Illuminate\Bus\Queueable;
use Enpii_Base\Deps\Illuminate\Foundation\Bus\Dispatchable;
use Enpii_Base\Deps\Illuminate\Queue\InteractsWithQueue;
use Enpii_Base\Deps\Illuminate\Queue\SerializesModels;

/**
 * This works as the base one for other Command Handlers to inherit
 * @package Enpii_Base\Foundation\Shared
 */
abstract class Base_Job_Command extends Base_Command {
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
}
