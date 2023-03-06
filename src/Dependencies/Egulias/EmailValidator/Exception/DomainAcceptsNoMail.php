<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception;

class DomainAcceptsNoMail extends InvalidEmail
{
    const CODE = 154;
    const REASON = 'Domain accepts no mail (Null MX, RFC7505)';
}
