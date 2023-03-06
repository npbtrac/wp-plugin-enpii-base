<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Warning;

class LabelTooLong extends Warning
{
    const CODE = 63;

    public function __construct()
    {
        $this->message = 'Label too long';
        $this->rfcNumber = 5322;
    }
}
