<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception;

class ConsecutiveAt extends InvalidEmail
{
    const CODE = 128;
    const REASON = "Consecutive AT";
}
