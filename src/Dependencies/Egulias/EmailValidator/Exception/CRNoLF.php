<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception;

class CRNoLF extends InvalidEmail
{
    const CODE = 150;
    const REASON = "Missing LF after CR";
}
