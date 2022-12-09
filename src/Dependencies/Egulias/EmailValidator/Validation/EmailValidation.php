<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Validation;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\EmailLexer;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception\InvalidEmail;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Warning\Warning;

interface EmailValidation
{
    /**
     * Returns true if the given email is valid.
     *
     * @param string     $email      The email you want to validate.
     * @param EmailLexer $emailLexer The email lexer.
     *
     * @return bool
     */
    public function isValid($email, EmailLexer $emailLexer);

    /**
     * Returns the validation error.
     *
     * @return InvalidEmail|null
     */
    public function getError();

    /**
     * Returns the validation warnings.
     *
     * @return Warning[]
     */
    public function getWarnings();
}
