<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Warning;

class DeprecatedComment extends Warning
{
    const CODE = 37;

    public function __construct()
    {
        $this->message = 'Deprecated comments';
    }
}
