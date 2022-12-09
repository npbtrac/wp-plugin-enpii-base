<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception;

class DomainHyphened extends InvalidEmail
{
    const CODE = 144;
    const REASON = "Hyphen found in domain";
}
