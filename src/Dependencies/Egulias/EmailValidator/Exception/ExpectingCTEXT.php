<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception;

class ExpectingCTEXT extends InvalidEmail
{
    const CODE = 139;
    const REASON = "Expecting CTEXT";
}
