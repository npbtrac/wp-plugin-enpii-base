<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Validation;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\EmailLexer;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Exception\InvalidEmail;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Egulias\EmailValidator\Validation\Error\RFCWarnings;

class NoRFCWarningsValidation extends RFCValidation
{
    /**
     * @var InvalidEmail|null
     */
    private $error;

    /**
     * {@inheritdoc}
     */
    public function isValid($email, EmailLexer $emailLexer)
    {
        if (!parent::isValid($email, $emailLexer)) {
            return false;
        }

        if (empty($this->getWarnings())) {
            return true;
        }

        $this->error = new RFCWarnings();

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getError()
    {
        return $this->error ?: parent::getError();
    }
}
