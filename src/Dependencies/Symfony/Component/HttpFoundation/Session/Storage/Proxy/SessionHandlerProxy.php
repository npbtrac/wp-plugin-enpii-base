<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Session\Storage\Proxy;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Session\Storage\Handler\StrictSessionHandler;

/**
 * @author Drak <drak@zikula.org>
 */
class SessionHandlerProxy extends AbstractProxy implements \SessionHandlerInterface, \SessionUpdateTimestampHandlerInterface
{
    protected $handler;

    public function __construct(\SessionHandlerInterface $handler)
    {
        $this->handler = $handler;
        $this->wrapper = $handler instanceof \SessionHandler;
        $this->saveHandlerName = $this->wrapper || ($handler instanceof StrictSessionHandler && $handler->isWrapper()) ? \ini_get('session.save_handler') : 'user';
    }

    /**
     * @return \SessionHandlerInterface
     */
    public function getHandler()
    {
        return $this->handler;
    }

    // \SessionHandlerInterface

    /**
     * @return bool
     */
    #[\NpWpNPB_ReturnTypeWillChange]
    public function open($savePath, $sessionName)
    {
        return $this->handler->open($savePath, $sessionName);
    }

    /**
     * @return bool
     */
    #[\NpWpNPB_ReturnTypeWillChange]
    public function close()
    {
        return $this->handler->close();
    }

    /**
     * @return string|false
     */
    #[\NpWpNPB_ReturnTypeWillChange]
    public function read($sessionId)
    {
        return $this->handler->read($sessionId);
    }

    /**
     * @return bool
     */
    #[\NpWpNPB_ReturnTypeWillChange]
    public function write($sessionId, $data)
    {
        return $this->handler->write($sessionId, $data);
    }

    /**
     * @return bool
     */
    #[\NpWpNPB_ReturnTypeWillChange]
    public function destroy($sessionId)
    {
        return $this->handler->destroy($sessionId);
    }

    /**
     * @return int|false
     */
    #[\NpWpNPB_ReturnTypeWillChange]
    public function gc($maxlifetime)
    {
        return $this->handler->gc($maxlifetime);
    }

    /**
     * @return bool
     */
    #[\NpWpNPB_ReturnTypeWillChange]
    public function validateId($sessionId)
    {
        return !$this->handler instanceof \SessionUpdateTimestampHandlerInterface || $this->handler->validateId($sessionId);
    }

    /**
     * @return bool
     */
    #[\NpWpNPB_ReturnTypeWillChange]
    public function updateTimestamp($sessionId, $data)
    {
        return $this->handler instanceof \SessionUpdateTimestampHandlerInterface ? $this->handler->updateTimestamp($sessionId, $data) : $this->write($sessionId, $data);
    }
}
