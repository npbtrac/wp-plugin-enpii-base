<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Validation;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\EmailLexer;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\EmailParser;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception\InvalidEmail;

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
