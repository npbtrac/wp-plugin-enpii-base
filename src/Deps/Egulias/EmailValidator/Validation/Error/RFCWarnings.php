<?php

namespace Enpii_Base\Deps\Egulias\EmailValidator\Validation\Error;

use Enpii_Base\Deps\Egulias\EmailValidator\Exception\InvalidEmail;

class RFCWarnings extends InvalidEmail
{
    const CODE = 997;
    const REASON = 'Warnings were found.';
}
