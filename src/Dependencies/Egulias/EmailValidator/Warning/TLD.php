<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Warning;

class TLD extends Warning
{
    const CODE = 9;

    public function __construct()
    {
        $this->message = "RFC5321, TLD";
    }
}
