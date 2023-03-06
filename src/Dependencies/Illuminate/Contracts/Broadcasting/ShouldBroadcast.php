<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Broadcasting;

interface ShouldBroadcast
{
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Broadcasting\Channel|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn();
}
