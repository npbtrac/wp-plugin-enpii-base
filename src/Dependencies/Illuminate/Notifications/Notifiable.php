<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Notifications;

trait Notifiable
{
    use HasDatabaseNotifications, RoutesNotifications;
}
