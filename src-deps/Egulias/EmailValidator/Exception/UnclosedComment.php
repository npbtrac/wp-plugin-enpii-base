<?php

namespace Enpii_Base\Deps\Egulias\EmailValidator\Exception;

class UnclosedComment extends InvalidEmail
{
    const CODE = 146;
    const REASON = "No closing comment token found";
}
