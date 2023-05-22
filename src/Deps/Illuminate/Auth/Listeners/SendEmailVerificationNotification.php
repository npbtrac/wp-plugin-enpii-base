<?php

namespace Enpii_Base\Deps\Illuminate\Auth\Listeners;

use Enpii_Base\Deps\Illuminate\Auth\Events\Registered;
use Enpii_Base\Deps\Illuminate\Contracts\Auth\MustVerifyEmail;

class SendEmailVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {
            $event->user->sendEmailVerificationNotification();
        }
    }
}
