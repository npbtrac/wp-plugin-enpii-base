<?php

namespace Enpii_Base\Deps\Illuminate\Contracts\Http;

interface Kernel
{
    /**
     * Bootstrap the application for HTTP requests.
     *
     * @return void
     */
    public function bootstrap();

    /**
     * Handle an incoming HTTP request.
     *
     * @param  \Enpii_Base\Deps\Symfony\Component\HttpFoundation\Request  $request
     * @return \Enpii_Base\Deps\Symfony\Component\HttpFoundation\Response
     */
    public function handle($request);

    /**
     * Perform any final actions for the request lifecycle.
     *
     * @param  \Enpii_Base\Deps\Symfony\Component\HttpFoundation\Request  $request
     * @param  \Enpii_Base\Deps\Symfony\Component\HttpFoundation\Response  $response
     * @return void
     */
    public function terminate($request, $response);

    /**
     * Get the Laravel application instance.
     *
     * @return \Enpii_Base\Deps\Illuminate\Contracts\Foundation\Application
     */
    public function getApplication();
}
