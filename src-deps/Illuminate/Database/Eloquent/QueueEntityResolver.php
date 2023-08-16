<?php

namespace Enpii_Base\Deps\Illuminate\Database\Eloquent;

use Enpii_Base\Deps\Illuminate\Contracts\Queue\EntityNotFoundException;
use Enpii_Base\Deps\Illuminate\Contracts\Queue\EntityResolver as EntityResolverContract;

class QueueEntityResolver implements EntityResolverContract
{
    /**
     * Resolve the entity for the given ID.
     *
     * @param  string  $type
     * @param  mixed  $id
     * @return mixed
     *
     * @throws \Enpii_Base\Deps\Illuminate\Contracts\Queue\EntityNotFoundException
     */
    public function resolve($type, $id)
    {
        $instance = (new $type)->find($id);

        if ($instance) {
            return $instance;
        }

        throw new EntityNotFoundException($type, $id);
    }
}
