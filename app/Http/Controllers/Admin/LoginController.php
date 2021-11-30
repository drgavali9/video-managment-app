<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class LoginController extends BaseController
{
	public function index()
	{
		return view('admin.login/index');
	}

	public function login(Request $request)
	{
		// validate the info, create rules for the inputs
		$rules = [
			'email' => 'required|email', // make sure the email is an actual email
			'password' => 'required|min:3' // password can only be alphanumeric and has to be greater than 3 characters
		];

		// run the validation rules on the inputs from the form
		$validator = Validator::make($request->all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
			return Redirect::to('admin/login')
				->withErrors($validator) // send back all errors to the login form
				->withInput($request->except('password')); // send back the input (not the password) so that we can repopulate the form
		} else {

			// create our user data for the authentication
			$userdata = array(
				'email' => $request->get('email'),
				'password' => $request->get('password'),
				'is_admin' => 1,
			);

			// attempt to do the login
			if (Auth::attempt($userdata)) {
				return Redirect::to('admin/videos');
			} else {
				return Redirect::to('admin/login')
					->withErrors(['msg', 'User email and password are not match.']);
			}
		}
	}

	public function destroy(Request $request)
	{
		Auth::guard('web')->logout();

		$request->session()->invalidate();

		$request->session()->regenerateToken();

		return redirect('/admin/login');
	}
}
