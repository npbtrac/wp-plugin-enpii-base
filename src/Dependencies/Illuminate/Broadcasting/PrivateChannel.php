<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Broadcasting;

class PrivateChannel extends Channel
{
    /**
     * Create a new channel instance.
     *
     * @param  string  $name
     * @return void
     */
    public function __construct($name)
    {
        parent::__construct('private-'.$name);
    }
}
