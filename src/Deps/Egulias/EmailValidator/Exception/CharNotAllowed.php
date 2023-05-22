<?php

namespace Enpii_Base\Deps\Egulias\EmailValidator\Exception;

class CharNotAllowed extends InvalidEmail
{
    const CODE = 201;
    const REASON = "Non allowed character in domain";
}
