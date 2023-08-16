<?php

namespace Enpii_Base\Deps\Egulias\EmailValidator\Validation\Error;

use Enpii_Base\Deps\Egulias\EmailValidator\Exception\InvalidEmail;

class SpoofEmail extends InvalidEmail
{
    const CODE = 998;
    const REASON = "The email contains mixed UTF8 chars that makes it suspicious";
}
