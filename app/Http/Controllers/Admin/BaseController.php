<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class BaseController extends Controller
{
	public $settings = '';
	public $currency = '';

	public function __construct()
	{
		$this->getSetting();
		$this->getCurrency();
		Validator::extend('existsWithOther', function ($attribute, $value, $parameters, $validator) {
			if (count($parameters) < 4) {
				throw new InvalidArgumentException("Validation rule game_fixture requires 4 parameters.");
			}

			$input = $validator->getData();
			$verifier = $validator->getPresenceVerifier();
			$collection = $parameters[0];
			$column = $parameters[1];
			$extra = [$parameters[2] => $parameters[3]];

			$count = $verifier->getMultiCount($collection, $column, (array)$value, $extra);

			return $count >= 1;
		});
	}

	private function getSetting()
	{
		$data = Setting::all()->pluck('value', 'key')->all();
		$this->settings = $data;
		$this->settings['currency'] = config('constants.currency');
		view()->share('settings', $this->settings);
	}

	private function getCurrency()
	{
		$this->currency = config('constants.currency');
	}
}
