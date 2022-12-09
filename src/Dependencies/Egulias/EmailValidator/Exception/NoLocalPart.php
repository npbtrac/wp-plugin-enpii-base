<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception;

class NoLocalPart extends InvalidEmail
{
    const CODE = 130;
    const REASON = "No local part";
}
