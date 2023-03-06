<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Warning;

class ObsoleteDTEXT extends Warning
{
    const CODE = 71;

    public function __construct()
    {
        $this->rfcNumber = 5322;
        $this->message = 'Obsolete DTEXT in domain literal';
    }
}
