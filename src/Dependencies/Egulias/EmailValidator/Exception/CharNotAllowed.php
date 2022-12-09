<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception;

class CharNotAllowed extends InvalidEmail
{
    const CODE = 201;
    const REASON = "Non allowed character in domain";
}
