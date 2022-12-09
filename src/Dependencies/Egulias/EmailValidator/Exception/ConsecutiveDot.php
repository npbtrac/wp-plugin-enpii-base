<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception;

class ConsecutiveDot extends InvalidEmail
{
    const CODE = 132;
    const REASON = "Consecutive DOT";
}
