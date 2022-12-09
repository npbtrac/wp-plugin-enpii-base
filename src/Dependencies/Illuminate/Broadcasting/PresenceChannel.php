<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Broadcasting;

class PresenceChannel extends Channel
{
    /**
     * Create a new channel instance.
     *
     * @param  string  $name
     * @return void
     */
    public function __construct($name)
    {
        parent::__construct('presence-'.$name);
    }
}
