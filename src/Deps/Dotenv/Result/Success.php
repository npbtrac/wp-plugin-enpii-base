<?php

namespace Enpii_Base\Deps\Dotenv\Result;

use Enpii_Base\Deps\PhpOption\None;
use Enpii_Base\Deps\PhpOption\Some;

/**
 * @template T
 * @template E
 * @extends \Enpii_Base\Deps\Dotenv\Result\Result<T,E>
 */
class Success extends Result
{
    /**
     * @var T
     */
    private $value;

    /**
     * Internal constructor for a success value.
     *
     * @param T $value
     *
     * @return void
     */
    private function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Create a new error value.
     *
     * @template S
     *
     * @param S $value
     *
     * @return \Enpii_Base\Deps\Dotenv\Result\Result<S,E>
     */
    public static function create($value)
    {
        return new self($value);
    }

    /**
     * Get the success option value.
     *
     * @return \Enpii_Base\Deps\PhpOption\Option<T>
     */
    public function success()
    {
        return Some::create($this->value);
    }

    /**
     * Map over the success value.
     *
     * @template S
     *
     * @param callable(T):S $f
     *
     * @return \Enpii_Base\Deps\Dotenv\Result\Result<S,E>
     */
    public function mapSuccess(callable $f)
    {
        return self::create($f($this->value));
    }

    /**
     * Get the error option value.
     *
     * @return \Enpii_Base\Deps\PhpOption\Option<E>
     */
    public function error()
    {
        return None::create();
    }

    /**
     * Map over the error value.
     *
     * @template F
     *
     * @param callable(E):F $f
     *
     * @return \Enpii_Base\Deps\Dotenv\Result\Result<T,F>
     */
    public function mapError(callable $f)
    {
        /** @var \Enpii_Base\Deps\Dotenv\Result\Result<T,F> */
        return self::create($this->value);
    }
}
