<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Warning;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\EmailParser;

class EmailTooLong extends Warning
{
    const CODE = 66;

    public function __construct()
    {
        $this->message = 'Email is too long, exceeds ' . EmailParser::EMAIL_MAX_LENGTH;
    }
}
