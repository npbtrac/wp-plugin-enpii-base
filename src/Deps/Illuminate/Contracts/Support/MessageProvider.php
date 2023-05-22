<?php

namespace Enpii_Base\Deps\Illuminate\Contracts\Support;

interface MessageProvider
{
    /**
     * Get the messages for the instance.
     *
     * @return \Enpii_Base\Deps\Illuminate\Contracts\Support\MessageBag
     */
    public function getMessageBag();
}
