<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception;

class ExpectingDTEXT extends InvalidEmail
{
    const CODE = 129;
    const REASON = "Expected DTEXT";
}
