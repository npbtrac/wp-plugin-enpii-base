<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Console\Scheduling;

interface CacheAware
{
    /**
     * Specify the cache store that should be used.
     *
     * @param  string  $store
     * @return $this
     */
    public function useStore($store);
}
