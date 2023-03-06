<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception;

class AtextAfterCFWS extends InvalidEmail
{
    const CODE = 133;
    const REASON = "ATEXT found after CFWS";
}
