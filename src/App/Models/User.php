<?php

declare(strict_types=1);

namespace Enpii_Base\App\Models;

use DateTimeImmutable;
use Enpii_Base\App\Support\Passport\Has_Api_Tokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Passport\Bridge\AccessTokenRepository;
use Laravel\Passport\ClientRepository;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

class User extends Authenticatable {
	use Has_Api_Tokens;
	use HasFactory;
	use Notifiable;

	protected $hidden = [
		'user_pass',
		'user_activation_key',
	];

	protected $fillable = [
		'ID',
		'user_login',
		'user_pass',
		'user_nicename',
		'user_email',
		'user_url',
		'user_registered',
		'user_activation_key',
		'user_status',
		'display_name',
		'spam',
		'deleted',
		'remember_token',
	];

	protected $primaryKey = 'ID';

	public function personal_access_by_request() {
		$name = wp_app_config( 'app.name' );
		return $this->createToken( $name, [ '*' ] );
	}
}
