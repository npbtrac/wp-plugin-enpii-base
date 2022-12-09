<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Warning;

class CFWSWithFWS extends Warning
{
    const CODE = 18;

    public function __construct()
    {
        $this->message = 'Folding whites space followed by folding white space';
    }
}
