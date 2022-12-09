<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Warning;

class CFWSNearAt extends Warning
{
    const CODE = 49;

    public function __construct()
    {
        $this->message = "Deprecated folding white space near @";
    }
}
