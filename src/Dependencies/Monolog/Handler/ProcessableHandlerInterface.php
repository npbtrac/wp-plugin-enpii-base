<?php declare(strict_types=1);

/*
 * This file is part of the Enpii\WP_Plugin\Enpii_Base\Dependencies\Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Monolog\Handler;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Monolog\Processor\ProcessorInterface;

/**
 * Interface to describe loggers that have processors
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 *
 * @phpstan-import-type Record from \Enpii\WP_Plugin\Enpii_Base\Dependencies\Monolog\Logger
 */
interface ProcessableHandlerInterface
{
    /**
     * Adds a processor in the stack.
     *
     * @psalm-param ProcessorInterface|callable(Record): Record $callback
     *
     * @param  ProcessorInterface|callable $callback
     * @return HandlerInterface            self
     */
    public function pushProcessor(callable $callback): HandlerInterface;

    /**
     * Removes the processor on top of the stack and returns it.
     *
     * @psalm-return ProcessorInterface|callable(Record): Record $callback
     *
     * @throws \LogicException             In case the processor stack is empty
     * @return callable|ProcessorInterface
     */
    public function popProcessor(): callable;
}
