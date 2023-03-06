<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Notifications;

trait HasDatabaseNotifications
{
    /**
     * Get the entity's notifications.
     *
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    /**
     * Get the entity's read notifications.
     *
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Query\Builder
     */
    public function readNotifications()
    {
        return $this->notifications()->whereNotNull('read_at');
    }

    /**
     * Get the entity's unread notifications.
     *
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Query\Builder
     */
    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }
}
