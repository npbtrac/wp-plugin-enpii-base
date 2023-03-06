<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Encryption;

interface Encrypter
{
    /**
     * Encrypt the given value.
     *
     * @param  mixed  $value
     * @param  bool  $serialize
     * @return string
     *
     * @throws \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Encryption\EncryptException
     */
    public function encrypt($value, $serialize = true);

    /**
     * Decrypt the given value.
     *
     * @param  string  $payload
     * @param  bool  $unserialize
     * @return mixed
     *
     * @throws \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Encryption\DecryptException
     */
    public function decrypt($payload, $unserialize = true);
}
