<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Validation\Error;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception\InvalidEmail;

class SpoofEmail extends InvalidEmail
{
    const CODE = 998;
    const REASON = "The email contains mixed UTF8 chars that makes it suspicious";
}
