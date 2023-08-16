<?php

namespace Enpii_Base\Deps\Illuminate\Validation\Concerns;

use Enpii_Base\Deps\Egulias\EmailValidator\EmailLexer;
use Enpii_Base\Deps\Egulias\EmailValidator\Validation\EmailValidation;

class FilterEmailValidation implements EmailValidation
{
    /**
     * The flags to pass to the filter_var function.
     *
     * @var int|null
     */
    protected $flags;

    /**
     * Create a new validation instance.
     *
     * @param  int  $flags
     * @return void
     */
    public function __construct($flags = null)
    {
        $this->flags = $flags;
    }

    /**
     * Create a new instance which allows any unicode characters in local-part.
     *
     * @return static
     */
    public static function unicode()
    {
        return new static(FILTER_FLAG_EMAIL_UNICODE);
    }

    /**
     * Returns true if the given email is valid.
     *
     * @param  string  $email
     * @param  \Enpii_Base\Deps\Egulias\EmailValidator\EmailLexer  $emailLexer
     * @return bool
     */
    public function isValid($email, EmailLexer $emailLexer)
    {
        return is_null($this->flags)
                    ? filter_var($email, FILTER_VALIDATE_EMAIL) !== false
                    : filter_var($email, FILTER_VALIDATE_EMAIL, $this->flags) !== false;
    }

    /**
     * Returns the validation error.
     *
     * @return \Enpii_Base\Deps\Egulias\EmailValidator\Exception\InvalidEmail|null
     */
    public function getError()
    {
        //
    }

    /**
     * Returns the validation warnings.
     *
     * @return \Enpii_Base\Deps\Egulias\EmailValidator\Warning\Warning[]
     */
    public function getWarnings()
    {
        return [];
    }
}
