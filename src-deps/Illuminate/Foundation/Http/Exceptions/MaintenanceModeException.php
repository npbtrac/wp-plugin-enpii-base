<?php

namespace Enpii_Base\Deps\Illuminate\Foundation\Http\Exceptions;

use Enpii_Base\Deps\Illuminate\Support\Carbon;
use Enpii_Base\Deps\Illuminate\Support\Facades\Date;
use Enpii_Base\Deps\Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Throwable;

class MaintenanceModeException extends ServiceUnavailableHttpException
{
    /**
     * When the application was put in maintenance mode.
     *
     * @var \Enpii_Base\Deps\Illuminate\Support\Carbon
     */
    public $wentDownAt;

    /**
     * The number of seconds to wait before retrying.
     *
     * @var int
     */
    public $retryAfter;

    /**
     * When the application should next be available.
     *
     * @var \Enpii_Base\Deps\Illuminate\Support\Carbon
     */
    public $willBeAvailableAt;

    /**
     * Create a new exception instance.
     *
     * @param  int  $time
     * @param  int|null  $retryAfter
     * @param  string|null  $message
     * @param  \Throwable|null  $previous
     * @param  int  $code
     * @return void
     */
    public function __construct($time, $retryAfter = null, $message = null, Throwable $previous = null, $code = 0)
    {
        parent::__construct($retryAfter, $message, $previous, $code);

        $this->wentDownAt = Date::createFromTimestamp($time);

        if ($retryAfter) {
            $this->retryAfter = $retryAfter;

            $this->willBeAvailableAt = Date::instance(Carbon::createFromTimestamp($time)->addRealSeconds($this->retryAfter));
        }
    }
}
