<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Support;

interface Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request);
}
