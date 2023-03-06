<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Validation;

interface ValidatesWhenResolved
{
    /**
     * Validate the given class instance.
     *
     * @return void
     */
    public function validateResolved();
}
