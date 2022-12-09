<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Notifications;

trait Notifiable
{
    use HasDatabaseNotifications, RoutesNotifications;
}
