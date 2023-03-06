<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Validation\Error;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception\InvalidEmail;

class RFCWarnings extends InvalidEmail
{
    const CODE = 997;
    const REASON = 'Warnings were found.';
}
