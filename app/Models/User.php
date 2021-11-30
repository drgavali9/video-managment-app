<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;
use Stripe\StripeClient;

class User extends Authenticatable
{
	use HasFactory, Notifiable;

	protected $table = "users";

	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'phone',
		'country_code',
		'password',
		'status',
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $casts = [
		'email_verified_at' => 'datetime'
	];


	public function getProfileImageAttribute($value)
	{
		if (isset($value) && !empty($value)) {
			if (strpos($value, 'http') === false) {
				$value = url(Config::get('imagepath.path.user.image') . $value);
			} else if (strpos($value, 'http') != 0) {
				$value = url(Config::get('imagepath.path.user.image') . $value);
			}
		} else {
			$value = url(Config::get('imagepath.default.user.image'));
		}
		return $value;
	}

}
