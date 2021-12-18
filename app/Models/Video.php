<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class Video extends Model
{
	use HasFactory;

	protected $fillable = [
		'userName',
		'userCountry',
		'userPicture',
		'video',
		'thumbnail',
		'view_count',
		'status',
	];

	public function getVideoAttribute($value)
	{
		if (isset($value) && !empty($value)) {
			if (strpos($value, 'http') === false) {
				$value = url('public/' . Config::get('imagepath.path.video') . $value);
			} else if (strpos($value, 'http') != 0) {
				$value = url('public/' . Config::get('imagepath.path.video') . $value);
			}
		} else {
			$value = url('public/' . Config::get('imagepath.default.video'));
		}
		return $value;
	}
	public function getThumbnailAttribute($value)
	{
		if (isset($value) && !empty($value)) {
			if (strpos($value, 'http') === false) {
				$value = url('public/' . Config::get('imagepath.path.thumbnail') . $value);
			} else if (strpos($value, 'http') != 0) {
				$value = url('public/' . Config::get('imagepath.path.thumbnail') . $value);
			}
		} else {
			$value = url('public/' . Config::get('imagepath.default.thumbnail'));
		}
		return $value;
	}
}
