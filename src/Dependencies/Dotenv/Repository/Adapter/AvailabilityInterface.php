<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Repository\Adapter;

interface AvailabilityInterface
{
    /**
     * Determines if the adapter is supported.
     *
     * @return bool
     */
    public function isSupported();
}
