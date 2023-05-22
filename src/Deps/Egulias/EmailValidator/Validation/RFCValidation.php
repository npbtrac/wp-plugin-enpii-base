<?php

namespace Enpii_Base\Deps\Egulias\EmailValidator\Validation;

use Enpii_Base\Deps\Egulias\EmailValidator\EmailLexer;
use Enpii_Base\Deps\Egulias\EmailValidator\EmailParser;
use Enpii_Base\Deps\Egulias\EmailValidator\Exception\InvalidEmail;

class RFCValidation implements EmailValidation
{
    /**
     * @var EmailParser|null
     */
    private $parser;

    /**
     * @var array
     */
    private $warnings = [];

    /**
     * @var InvalidEmail|null
     */
    private $error;

    public function isValid($email, EmailLexer $emailLexer)
    {
        $this->parser = new EmailParser($emailLexer);
        try {
            $this->parser->parse((string)$email);
        } catch (InvalidEmail $invalid) {
            $this->error = $invalid;
            return false;
        }

        $this->warnings = $this->parser->getWarnings();
        return true;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getWarnings()
    {
        return $this->warnings;
    }
}
