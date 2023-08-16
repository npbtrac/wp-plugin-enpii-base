<?php

namespace Enpii_Base\Deps\Illuminate\Contracts\Support;

interface Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @return \Enpii_Base\Deps\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request);
}
