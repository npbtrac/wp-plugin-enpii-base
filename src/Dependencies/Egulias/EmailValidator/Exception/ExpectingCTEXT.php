<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception;

class ExpectingCTEXT extends InvalidEmail
{
    const CODE = 139;
    const REASON = "Expecting CTEXT";
}
