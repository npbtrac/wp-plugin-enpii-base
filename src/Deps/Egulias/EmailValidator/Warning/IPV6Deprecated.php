<?php

namespace Enpii_Base\Deps\Egulias\EmailValidator\Warning;

class IPV6Deprecated extends Warning
{
    const CODE = 13;

    public function __construct()
    {
        $this->message = 'Deprecated form of IPV6';
        $this->rfcNumber = 5321;
    }
}
