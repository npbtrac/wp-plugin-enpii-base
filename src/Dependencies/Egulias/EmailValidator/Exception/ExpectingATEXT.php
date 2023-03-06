<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception;

class ExpectingATEXT extends InvalidEmail
{
    const CODE = 137;
    const REASON = "Expecting ATEXT";
}
