<?php

namespace Enpii_Base\Deps\Illuminate\Foundation\Auth;

use Enpii_Base\Deps\Illuminate\Auth\Authenticatable;
use Enpii_Base\Deps\Illuminate\Auth\MustVerifyEmail;
use Enpii_Base\Deps\Illuminate\Auth\Passwords\CanResetPassword;
use Enpii_Base\Deps\Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Enpii_Base\Deps\Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Enpii_Base\Deps\Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Enpii_Base\Deps\Illuminate\Database\Eloquent\Model;
use Enpii_Base\Deps\Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
}
