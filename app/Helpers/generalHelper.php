<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

function jsonDecode($value)
{
	if ($value === NULL) {
		$value = [];
	}
	if (is_json($value)) {
		return json_decode($value, TRUE);
	} else {
		return $value;
	}
}

function singeValue($value)
{
	if ($value === NULL) {
		$value = '';
	}
	return $value;
}

function is_json($string)
{
	if (is_array($string)) {
		return FALSE;
	}

	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}

// $device_token=['2beaf6d7-5632-4336-90fd-4f3155cbbc36'];
// $heading=['en'=>'test'];
// $content=['en'=>'test message'];
function noticeSendToUser($device_token, $heading, $content, $data)
{
	try {
		$fields = array(
			'app_id' => env('ONESIGNAL_APP_ID', 'ef5151ad-9ff1-4e62-9de6-9896fbf16f5f'),
			'data' => $data,
			'include_player_ids' => $device_token, // ['2beaf6d7-5632-4336-90fd-4f3155cbbc36']
			'ios_badgeType' => "Increase",
			// 'ios_badgeCount' => 0,
			'headings' => $heading, // ['en'=>'']
			'contents' => $content, // ['en'=>'']
		);

		$fields = json_encode($fields);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json; charset=utf-8',
			'Authorization: Basic ' . env('ONESIGNAL_REST_API_KEY', 'ZjM1MjM2OWQtZmRlNy00N2UzLWEwZmItZjZiZGMyZTYyYzQy')
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$response = curl_exec($ch);
		curl_close($ch);
		$return = json_decode($response, true);
		return $return;
	} catch (Exception $e) {
		return ['success' => FALSE, 'message' => $e->getMessage()];
	}
}


function multiDimensionalArrayDecode($array)
{
	foreach ($array as $key => &$value) {
		if (is_json($value)) {
			$value = json_decode($value, TRUE);
		} else if (is_array($value)) {
			$value = multiDimensionalArrayDecode($value);
		}
	}
	$array = nullableConvert($array);
	return $array;
}


function nullableConvert($array)
{
	foreach ($array as $key => &$value) {
		if (is_array($value)) {
			$value = nullableConvert($value);
		} else if ($value == NULL) {
			$value = '';
		}
	}
	return $array;
}


// PHP function to print a
// random string of length n
function RandomStringGenerator($n)
{
	// Variable which store final string
	$generated_string = "";

	// Create a string with the help of
	// small letters, capital letters and
	// digits.
	$domain = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

	// Find the length of created string
	$len = strlen($domain);

	// Loop to create random string
	for ($i = 0; $i < $n; $i++) {
		// Generate a random index to pick
		// characters
		$index = rand(0, $len - 1);

		// Concatenating the character
		// in resultant string
		$generated_string = $generated_string . $domain[$index];
	}

	// Return the random generated string
	return $generated_string;
}

// $get=value/key
function searchForId($id, $key, $array, $get = 'value')
{
	foreach ($array as $k => $val) {
		if ($val[$key] == $id) {
			if ($get == 'value')
				return $val;
			else
				return $k;
		}
	}
	return null;
}

function paginate($items, $perPage = 5, $page = null, $options = [])
{
	$page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
	$items = $items instanceof Collection ? $items : Collection::make($items);
	return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
}


function arrayKeyChange($array, $SearchKey, $ReplaceKey)
{
	$iReturn = [];

	if (!empty($array)) {
		foreach ($array as $key => $value) {
			$iData = [];
			foreach ($value as $key1 => $value1) {
				if (strpos($key1, $SearchKey) >= 0) {
					$iData[str_replace($SearchKey, $ReplaceKey, $key1)] = $value1;
				} else {
					$iData[$key1] = $value1;
				}
			}
			if (!empty($iData)) {
				array_push($iReturn, $iData);
			}
		}
	}

	return $iReturn;
}


function array_replace_key($search, $replace, array $subject)
{
	$updatedArray = [];

	foreach ($subject as $key => $value) {
		if (!is_array($value) && $key == $search) {
			$updatedArray = array_merge($updatedArray, [$replace => $value]);

			continue;
		}

		$updatedArray = array_merge($updatedArray, [$key => $value]);
	}

	return $updatedArray;
}

function convertDecimal($value, $digit = 2)
{
	return number_format((float)$value, $digit, '.', '');
}

function slug_make($value, $pattern = "/[^a-zA-Z0-9]+/")
{
	return strtolower(preg_replace($pattern, "-", $value));
}

function formatSizeUnits($bytes)
{
	if ($bytes >= 1073741824) {
		$bytes = number_format($bytes / 1073741824, 2) . ' GB';
	} elseif ($bytes >= 1048576) {
		$bytes = number_format($bytes / 1048576, 2) . ' MB';
	} elseif ($bytes >= 1024) {
		$bytes = number_format($bytes / 1024, 2) . ' KB';
	} elseif ($bytes > 1) {
		$bytes = $bytes . ' bytes';
	} elseif ($bytes == 1) {
		$bytes = $bytes . ' byte';
	} else {
		$bytes = '0 bytes';
	}

	return $bytes;
}
