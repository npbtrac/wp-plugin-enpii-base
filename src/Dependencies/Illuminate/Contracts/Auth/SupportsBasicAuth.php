<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth;

interface SupportsBasicAuth
{
    /**
     * Attempt to authenticate using HTTP Basic Auth.
     *
     * @param  string  $field
     * @param  array  $extraConditions
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response|null
     */
    public function basic($field = 'email', $extraConditions = []);

    /**
     * Perform a stateless HTTP Basic login attempt.
     *
     * @param  string  $field
     * @param  array  $extraConditions
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response|null
     */
    public function onceBasic($field = 'email', $extraConditions = []);
}
