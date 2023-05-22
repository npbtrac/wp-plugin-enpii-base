<?php

namespace Enpii_Base\Deps\Illuminate\Notifications;

use Enpii_Base\Deps\Illuminate\Bus\Queueable;
use Enpii_Base\Deps\Illuminate\Contracts\Queue\ShouldQueue;
use Enpii_Base\Deps\Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Enpii_Base\Deps\Illuminate\Database\Eloquent\Model;
use Enpii_Base\Deps\Illuminate\Queue\InteractsWithQueue;
use Enpii_Base\Deps\Illuminate\Queue\SerializesModels;
use Enpii_Base\Deps\Illuminate\Support\Collection;

class SendQueuedNotifications implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The notifiable entities that should receive the notification.
     *
     * @var \Enpii_Base\Deps\Illuminate\Support\Collection
     */
    public $notifiables;

    /**
     * The notification to be sent.
     *
     * @var \Enpii_Base\Deps\Illuminate\Notifications\Notification
     */
    public $notification;

    /**
     * All of the channels to send the notification to.
     *
     * @var array
     */
    public $channels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout;

    /**
     * Create a new job instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Notifications\Notifiable|\Enpii_Base\Deps\Illuminate\Support\Collection  $notifiables
     * @param  \Enpii_Base\Deps\Illuminate\Notifications\Notification  $notification
     * @param  array|null  $channels
     * @return void
     */
    public function __construct($notifiables, $notification, array $channels = null)
    {
        $this->channels = $channels;
        $this->notification = $notification;
        $this->notifiables = $this->wrapNotifiables($notifiables);
        $this->tries = property_exists($notification, 'tries') ? $notification->tries : null;
        $this->timeout = property_exists($notification, 'timeout') ? $notification->timeout : null;
    }

    /**
     * Wrap the notifiable(s) in a collection.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Notifications\Notifiable|\Enpii_Base\Deps\Illuminate\Support\Collection  $notifiables
     * @return \Enpii_Base\Deps\Illuminate\Support\Collection
     */
    protected function wrapNotifiables($notifiables)
    {
        if ($notifiables instanceof Collection) {
            return $notifiables;
        } elseif ($notifiables instanceof Model) {
            return EloquentCollection::wrap($notifiables);
        }

        return Collection::wrap($notifiables);
    }

    /**
     * Send the notifications.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Notifications\ChannelManager  $manager
     * @return void
     */
    public function handle(ChannelManager $manager)
    {
        $manager->sendNow($this->notifiables, $this->notification, $this->channels);
    }

    /**
     * Get the display name for the queued job.
     *
     * @return string
     */
    public function displayName()
    {
        return get_class($this->notification);
    }

    /**
     * Call the failed method on the notification instance.
     *
     * @param  \Throwable  $e
     * @return void
     */
    public function failed($e)
    {
        if (method_exists($this->notification, 'failed')) {
            $this->notification->failed($e);
        }
    }

    /**
     * Get the retry delay for the notification.
     *
     * @return mixed
     */
    public function retryAfter()
    {
        if (! method_exists($this->notification, 'retryAfter') && ! isset($this->notification->retryAfter)) {
            return;
        }

        return $this->notification->retryAfter ?? $this->notification->retryAfter();
    }

    /**
     * Get the expiration for the notification.
     *
     * @return mixed
     */
    public function retryUntil()
    {
        if (! method_exists($this->notification, 'retryUntil') && ! isset($this->notification->timeoutAt)) {
            return;
        }

        return $this->notification->timeoutAt ?? $this->notification->retryUntil();
    }

    /**
     * Prepare the instance for cloning.
     *
     * @return void
     */
    public function __clone()
    {
        $this->notifiables = clone $this->notifiables;
        $this->notification = clone $this->notification;
    }
}
