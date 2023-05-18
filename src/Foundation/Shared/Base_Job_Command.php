<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Foundation\Shared;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Bus\Queueable;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bus\Dispatchable;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Queue\InteractsWithQueue;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Queue\SerializesModels;

/**
 * This works as the base one for other Command Handlers to inherit
 * @package Enpii\WP_Plugin\Enpii_Base\Foundation\Shared
 */
abstract class Base_Job_Command extends Base_Command {
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
}
