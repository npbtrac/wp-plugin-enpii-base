<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Validation;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Validation\Factory;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Validation\ValidationException;

trait ValidatesRequests
{
    /**
     * Run the validation routine against the given validator.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Validation\Validator|array  $validator
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request|null  $request
     * @return array
     *
     * @throws \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Validation\ValidationException
     */
    public function validateWith($validator, Request $request = null)
    {
        $request = $request ?: wp_app_request();

        if (is_array($validator)) {
            $validator = $this->getValidationFactory()->make($request->all(), $validator);
        }

        return $validator->validate();
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return array
     *
     * @throws \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Validation\ValidationException
     */
    public function validate(Request $request, array $rules,
                             array $messages = [], array $customAttributes = [])
    {
        return $this->getValidationFactory()->make(
            $request->all(), $rules, $messages, $customAttributes
        )->validate();
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  string  $errorBag
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return array
     *
     * @throws \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Validation\ValidationException
     */
    public function validateWithBag($errorBag, Request $request, array $rules,
                                    array $messages = [], array $customAttributes = [])
    {
        try {
            return $this->validate($request, $rules, $messages, $customAttributes);
        } catch (ValidationException $e) {
            $e->errorBag = $errorBag;

            throw $e;
        }
    }

    /**
     * Get a validation factory instance.
     *
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Validation\Factory
     */
    protected function getValidationFactory()
    {
        return wp_app(Factory::class);
    }
}
