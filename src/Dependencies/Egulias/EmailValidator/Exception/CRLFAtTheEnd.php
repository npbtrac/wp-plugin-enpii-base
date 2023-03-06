<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception;

class CRLFAtTheEnd extends InvalidEmail
{
    const CODE = 149;
    const REASON = "CRLF at the end";
}
