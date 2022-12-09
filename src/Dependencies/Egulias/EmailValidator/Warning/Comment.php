<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Warning;

class Comment extends Warning
{
    const CODE = 17;

    public function __construct()
    {
        $this->message = "Comments found in this email";
    }
}
