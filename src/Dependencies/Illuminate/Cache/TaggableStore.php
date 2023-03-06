<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Cache;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Cache\Store;

abstract class TaggableStore implements Store
{
    /**
     * Begin executing a new tags operation.
     *
     * @param  array|mixed  $names
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Cache\TaggedCache
     */
    public function tags($names)
    {
        return new TaggedCache($this, new TagSet($this, is_array($names) ? $names : func_get_args()));
    }
}
