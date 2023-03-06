<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception;

class NoDNSRecord extends InvalidEmail
{
    const CODE = 5;
    const REASON = 'No MX or A DSN record was found for this email';
}
