<?php
/* ===========================================================================
 * Copyright (c) 2018-2021 Zindex Software
 *
 * Licensed under the MIT License
 * =========================================================================== */

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Opis\Closure;

interface ISecurityProvider
{
    /**
     * Sign serialized closure
     * @param string $closure
     * @return array
     */
    public function sign($closure);

    /**
     * Verify signature
     * @param array $data
     * @return bool
     */
    public function verify(array $data);
}