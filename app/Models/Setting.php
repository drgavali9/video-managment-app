<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class Setting extends Model
{
	use HasFactory;

	protected $fillable = [
		'type',
		'key',
		'value',
	];
}
