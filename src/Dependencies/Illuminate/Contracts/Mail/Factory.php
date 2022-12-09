<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Mail;

interface Factory
{
    /**
     * Get a mailer instance by name.
     *
     * @param  string|null  $name
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Mail\Mailer
     */
    public function mailer($name = null);
}
