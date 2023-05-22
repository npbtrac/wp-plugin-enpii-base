<?php

namespace Enpii_Base\Deps\Egulias\EmailValidator\Warning;

use Enpii_Base\Deps\Egulias\EmailValidator\EmailParser;

class EmailTooLong extends Warning
{
    const CODE = 66;

    public function __construct()
    {
        $this->message = 'Email is too long, exceeds ' . EmailParser::EMAIL_MAX_LENGTH;
    }
}
