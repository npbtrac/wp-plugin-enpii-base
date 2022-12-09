<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Auth;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Auth\Authenticatable;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Auth\MustVerifyEmail;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Auth\Passwords\CanResetPassword;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Eloquent\Model;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
}
