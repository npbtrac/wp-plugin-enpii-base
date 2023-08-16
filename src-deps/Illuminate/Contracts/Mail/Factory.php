<?php

namespace Enpii_Base\Deps\Illuminate\Contracts\Mail;

interface Factory
{
    /**
     * Get a mailer instance by name.
     *
     * @param  string|null  $name
     * @return \Enpii_Base\Deps\Illuminate\Mail\Mailer
     */
    public function mailer($name = null);
}
