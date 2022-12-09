<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception;

class NoDomainPart extends InvalidEmail
{
    const CODE = 131;
    const REASON = "No Domain part";
}
