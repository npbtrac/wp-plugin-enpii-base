<?php

namespace Enpii_Base\Deps\Illuminate\Contracts\Broadcasting;

interface ShouldBroadcast
{
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Enpii_Base\Deps\Illuminate\Broadcasting\Channel|\Enpii_Base\Deps\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn();
}
