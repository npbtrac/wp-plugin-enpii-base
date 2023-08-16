<?php

namespace Enpii_Base\Deps\Illuminate\Http;

use Enpii_Base\Deps\Illuminate\Contracts\Support\MessageProvider;
use Enpii_Base\Deps\Illuminate\Session\Store as SessionStore;
use Enpii_Base\Deps\Illuminate\Support\MessageBag;
use Enpii_Base\Deps\Illuminate\Support\Str;
use Enpii_Base\Deps\Illuminate\Support\Traits\ForwardsCalls;
use Enpii_Base\Deps\Illuminate\Support\Traits\Macroable;
use Enpii_Base\Deps\Illuminate\Support\ViewErrorBag;
use Enpii_Base\Deps\Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;
use Enpii_Base\Deps\Symfony\Component\HttpFoundation\RedirectResponse as BaseRedirectResponse;

class RedirectResponse extends BaseRedirectResponse
{
    use ForwardsCalls, ResponseTrait, Macroable {
        Macroable::__call as macroCall;
    }

    /**
     * The request instance.
     *
     * @var \Enpii_Base\Deps\Illuminate\Http\Request
     */
    protected $request;

    /**
     * The session store instance.
     *
     * @var \Enpii_Base\Deps\Illuminate\Session\Store
     */
    protected $session;

    /**
     * Flash a piece of data to the session.
     *
     * @param  string|array  $key
     * @param  mixed  $value
     * @return $this
     */
    public function with($key, $value = null)
    {
        $key = is_array($key) ? $key : [$key => $value];

        foreach ($key as $k => $v) {
            $this->session->flash($k, $v);
        }

        return $this;
    }

    /**
     * Add multiple cookies to the response.
     *
     * @param  array  $cookies
     * @return $this
     */
    public function withCookies(array $cookies)
    {
        foreach ($cookies as $cookie) {
            $this->headers->setCookie($cookie);
        }

        return $this;
    }

    /**
     * Flash an array of input to the session.
     *
     * @param  array|null  $input
     * @return $this
     */
    public function withInput(array $input = null)
    {
        $this->session->flashInput($this->removeFilesFromInput(
            ! is_null($input) ? $input : $this->request->input()
        ));

        return $this;
    }

    /**
     * Remove all uploaded files form the given input array.
     *
     * @param  array  $input
     * @return array
     */
    protected function removeFilesFromInput(array $input)
    {
        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $input[$key] = $this->removeFilesFromInput($value);
            }

            if ($value instanceof SymfonyUploadedFile) {
                unset($input[$key]);
            }
        }

        return $input;
    }

    /**
     * Flash an array of input to the session.
     *
     * @return $this
     */
    public function onlyInput()
    {
        return $this->withInput($this->request->only(func_get_args()));
    }

    /**
     * Flash an array of input to the session.
     *
     * @return $this
     */
    public function exceptInput()
    {
        return $this->withInput($this->request->except(func_get_args()));
    }

    /**
     * Flash a container of errors to the session.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Support\MessageProvider|array|string  $provider
     * @param  string  $key
     * @return $this
     */
    public function withErrors($provider, $key = 'default')
    {
        $value = $this->parseErrors($provider);

        $errors = $this->session->get('errors', new ViewErrorBag);

        if (! $errors instanceof ViewErrorBag) {
            $errors = new ViewErrorBag;
        }

        $this->session->flash(
            'errors', $errors->put($key, $value)
        );

        return $this;
    }

    /**
     * Add a fragment identifier to the URL.
     *
     * @param  string  $fragment
     * @return $this
     */
    public function withFragment($fragment)
    {
        return $this->withoutFragment()
                ->setTargetUrl($this->getTargetUrl().'#'.Str::after($fragment, '#'));
    }

    /**
     * Remove any fragment identifier from the response URL.
     *
     * @return $this
     */
    public function withoutFragment()
    {
        return $this->setTargetUrl(Str::before($this->getTargetUrl(), '#'));
    }

    /**
     * Parse the given errors into an appropriate value.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Support\MessageProvider|array|string  $provider
     * @return \Enpii_Base\Deps\Illuminate\Support\MessageBag
     */
    protected function parseErrors($provider)
    {
        if ($provider instanceof MessageProvider) {
            return $provider->getMessageBag();
        }

        return new MessageBag((array) $provider);
    }

    /**
     * Get the original response content.
     *
     * @return null
     */
    public function getOriginalContent()
    {
        //
    }

    /**
     * Get the request instance.
     *
     * @return \Enpii_Base\Deps\Illuminate\Http\Request|null
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set the request instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Http\Request  $request
     * @return void
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the session store instance.
     *
     * @return \Enpii_Base\Deps\Illuminate\Session\Store|null
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set the session store instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Session\Store  $session
     * @return void
     */
    public function setSession(SessionStore $session)
    {
        $this->session = $session;
    }

    /**
     * Dynamically bind flash data in the session.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        if (Str::startsWith($method, 'with')) {
            return $this->with(Str::snake(substr($method, 4)), $parameters[0]);
        }

        static::throwBadMethodCallException($method);
    }
}
