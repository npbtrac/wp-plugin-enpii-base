<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Session;

interface ExistenceAwareInterface
{
    /**
     * Set the existence state for the session.
     *
     * @param  bool  $value
     * @return \SessionHandlerInterface
     */
    public function setExists($value);
}
