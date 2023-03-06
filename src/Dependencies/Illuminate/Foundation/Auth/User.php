<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Auth;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Auth\Authenticatable;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Auth\MustVerifyEmail;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Auth\Passwords\CanResetPassword;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Eloquent\Model;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
}
