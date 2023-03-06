<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception;

class UnclosedComment extends InvalidEmail
{
    const CODE = 146;
    const REASON = "No closing comment token found";
}
