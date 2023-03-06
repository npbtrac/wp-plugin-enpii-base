<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Notifications\Events;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Bus\Queueable;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Queue\SerializesModels;

class NotificationSending
{
    use Queueable, SerializesModels;

    /**
     * The notifiable entity who received the notification.
     *
     * @var mixed
     */
    public $notifiable;

    /**
     * The notification instance.
     *
     * @var \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Notifications\Notification
     */
    public $notification;

    /**
     * The channel name.
     *
     * @var string
     */
    public $channel;

    /**
     * Create a new event instance.
     *
     * @param  mixed  $notifiable
     * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Notifications\Notification  $notification
     * @param  string  $channel
     * @return void
     */
    public function __construct($notifiable, $notification, $channel)
    {
        $this->channel = $channel;
        $this->notifiable = $notifiable;
        $this->notification = $notification;
    }
}
