<?php

declare(strict_types=1);

namespace Enpii_Base\Foundation\Shared\Interfaces;

/**
 * We use this inteface to determine if a handler is a Command Handler
 * @package Enpii_Base\Foundation\Shared\Interfaces
 * @method void handle()	We only use annotation here because we want to tie the specific
 * 							command class name to this handle() method
 */
interface Command_Handler_Interface {
}
