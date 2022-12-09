<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\View;

use ErrorException;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Container\Container;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Reflector;

class ViewException extends ErrorException
{
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        $exception = $this->getPrevious();

        if (Reflector::isCallable($reportCallable = [$exception, 'report'])) {
            return Container::getInstance()->call($reportCallable);
        }

        return false;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Response
     */
    public function render($request)
    {
        $exception = $this->getPrevious();

        if ($exception && method_exists($exception, 'render')) {
            return $exception->render($request);
        }
    }
}
