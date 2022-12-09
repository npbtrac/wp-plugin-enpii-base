<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Exception\ValidationException;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Regex\Regex;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Repository\RepositoryInterface;

class Validator
{
    /**
     * The environment repository instance.
     *
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Repository\RepositoryInterface
     */
    protected $repository;

    /**
     * The variables to validate.
     *
     * @var string[]
     */
    protected $variables;

    /**
     * Create a new validator instance.
     *
     * @param \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Repository\RepositoryInterface $repository
     * @param string[]                               $variables
     * @param bool                                   $required
     *
     * @throws \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Exception\ValidationException
     *
     * @return void
     */
    public function __construct(RepositoryInterface $repository, array $variables, $required = true)
    {
        $this->repository = $repository;
        $this->variables = $variables;

        if ($required) {
            $this->assertCallback(
                function ($value) {
                    return $value !== null;
                },
                'is missing'
            );
        }
    }

    /**
     * Assert that each variable is not empty.
     *
     * @throws \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Exception\ValidationException
     *
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Validator
     */
    public function notEmpty()
    {
        return $this->assertCallback(
            function ($value) {
                if ($value === null) {
                    return true;
                }

                return strlen(trim($value)) > 0;
            },
            'is empty'
        );
    }

    /**
     * Assert that each specified variable is an integer.
     *
     * @throws \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Exception\ValidationException
     *
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Validator
     */
    public function isInteger()
    {
        return $this->assertCallback(
            function ($value) {
                if ($value === null) {
                    return true;
                }

                return ctype_digit($value);
            },
            'is not an integer'
        );
    }

    /**
     * Assert that each specified variable is a boolean.
     *
     * @throws \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Exception\ValidationException
     *
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Validator
     */
    public function isBoolean()
    {
        return $this->assertCallback(
            function ($value) {
                if ($value === null) {
                    return true;
                }

                if ($value === '') {
                    return false;
                }

                return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null;
            },
            'is not a boolean'
        );
    }

    /**
     * Assert that each variable is amongst the given choices.
     *
     * @param string[] $choices
     *
     * @throws \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Exception\ValidationException
     *
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Validator
     */
    public function allowedValues(array $choices)
    {
        return $this->assertCallback(
            function ($value) use ($choices) {
                if ($value === null) {
                    return true;
                }

                return in_array($value, $choices, true);
            },
            sprintf('is not one of [%s]', implode(', ', $choices))
        );
    }

    /**
     * Assert that each variable matches the given regular expression.
     *
     * @param string $regex
     *
     * @throws \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Exception\ValidationException
     *
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Validator
     */
    public function allowedRegexValues($regex)
    {
        return $this->assertCallback(
            function ($value) use ($regex) {
                if ($value === null) {
                    return true;
                }

                return Regex::match($regex, $value)->success()->getOrElse(0) === 1;
            },
            sprintf('does not match "%s"', $regex)
        );
    }

    /**
     * Assert that the callback returns true for each variable.
     *
     * @param callable $callback
     * @param string   $message
     *
     * @throws \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Exception\ValidationException
     *
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Validator
     */
    protected function assertCallback(callable $callback, $message = 'failed callback assertion')
    {
        $failing = [];

        foreach ($this->variables as $variable) {
            if ($callback($this->repository->get($variable)) === false) {
                $failing[] = sprintf('%s %s', $variable, $message);
            }
        }

        if (count($failing) > 0) {
            throw new ValidationException(sprintf(
                'One or more environment variables failed assertions: %s.',
                implode(', ', $failing)
            ));
        }

        return $this;
    }
}
