<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Broadcasting;

interface ShouldBroadcast
{
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Broadcasting\Channel|\Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn();
}
