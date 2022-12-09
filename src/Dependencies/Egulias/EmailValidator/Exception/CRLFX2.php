<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception;

class CRLFX2 extends InvalidEmail
{
    const CODE = 148;
    const REASON = "Folding whitespace CR LF found twice";
}
