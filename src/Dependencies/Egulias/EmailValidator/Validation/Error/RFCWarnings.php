<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Validation\Error;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception\InvalidEmail;

class RFCWarnings extends InvalidEmail
{
    const CODE = 997;
    const REASON = 'Warnings were found.';
}
