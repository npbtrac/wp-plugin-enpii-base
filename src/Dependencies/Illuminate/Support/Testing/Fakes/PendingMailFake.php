<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Testing\Fakes;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Mail\Mailable;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Mail\PendingMail;

class PendingMailFake extends PendingMail
{
    /**
     * Create a new instance.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Testing\Fakes\MailFake  $mailer
     * @return void
     */
    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send a new mailable message instance.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Mail\Mailable  $mailable
     * @return mixed
     */
    public function send(Mailable $mailable)
    {
        return $this->mailer->send($this->fill($mailable));
    }

    /**
     * Send a mailable message immediately.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Mail\Mailable  $mailable
     * @return mixed
     *
     * @deprecated Use send() instead.
     */
    public function sendNow(Mailable $mailable)
    {
        return $this->send($mailable);
    }

    /**
     * Push the given mailable onto the queue.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Mail\Mailable  $mailable
     * @return mixed
     */
    public function queue(Mailable $mailable)
    {
        return $this->mailer->queue($this->fill($mailable));
    }
}
