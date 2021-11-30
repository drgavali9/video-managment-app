<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Frontend\BaseController;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Country;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Edujugon\Laradoo\Odoo;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends BaseController
{


	/**
	 * Display the registration view.
	 *
	 * @return View
	 */
	public function create()
	{
		$countries = Country::where('status', 1)->get();
		return view('auth.register', compact('countries'));
	}

	/**
	 * Handle an incoming registration request.
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 *
	 * @throws ValidationException
	 */
	public function store(Request $request)
	{
		request()->validate([
			'first_name' => 'required|string|max:255|regex:/^[A-Za-z]+$/',
			'last_name' => 'required|string|max:255|regex:/^[A-Za-z]+$/',
			'email' => 'required|string|email|max:255|unique:users',
			'phone' => 'required|regex:/[0-9]{10}/|digits:10|unique:users',
			'phone_code' => 'required',
			'password' => 'required|string|min:8',
		], [
			'first_name.regex' => 'First name must be only string',
			'last_name.regex' => 'Last name must be only string',
			'phone.regex' => 'Phoneno must be only degits',
		]);
		$odoo_user_id = null;
		try {
			$finalphonenumber = $request->post('phone_code') . $request->post('phone');
			if (config('constants.odoo_flag') == "true") {
				$this->odooClient = new Odoo();
				$this->odooClient = $this->odooClient->db(config('laradoo.db'))->host(config('laradoo.host'))->username(config('laradoo.username'))->password(config('laradoo.password'))->connect();

				$name = $request->post('first_name') . $request->post('last_name');
				Log::info("start user registration");
				$newoddouser_id = $this->odooClient->create('res.partner', [
					'name' => $name,
					'email' => $request->post('email'),
					'active' => true,
				]);
				$odoo_user_id = $newoddouser_id;
				Log::info("odoo log :" . $newoddouser_id);
			}
		} catch (\Exception $e) {
			Log::info("odoo error :" . $e);
			$request->session()->flash('error', 'Registration Fail');
			return;
		}


		$user = null;
		$newslatter = $request->post('subscribe_to_our_newsletter') == 'on' ? '1' : '0';

		$id = $customer[0]['id'] ?? null;
		$customerid = (string)$id;
		$newslatter = $request->post('subscribe_to_our_newsletter') == 'on' ? '1' : '0';
		$user = User::updateOrCreate(
			[
				'first_name' => trim($request->post('first_name')),
				'last_name' => trim($request->post('last_name')),
				'email' => $request->post('email'),
				'phone' => trim($request->post('phone')),
				'country_code' => $request->post('phone_code'),
				'subscribe_to_our_newsletter' => $newslatter,
				'status' => 1,
				'password' => Hash::make($request->password),
				'customer_id' => $odoo_user_id
			]
		);


		event(new Registered($user));

		Auth::login($user);

		// merge cart code
		$mac_address = substr(exec('getmac'), 0, 17);
		$userID = auth()->user()->id;
		$cart = Cart::with('cartdetails')->where('user_id', $userID)->first();
		if ($cart == null) {
			$cart = new Cart();
			$cart->user_id = auth()->user()->id;
			$cart->mac_address = $mac_address;
			$cart->save();
		}
		$n_cart = Cart::with('cartdetails')->where('user_id', null)->where('mac_address', $mac_address)->first();
		if (!empty($n_cart)) {
			$n_cart->cart_total = $cart->cart_total + $n_cart->cart_total;
			$n_cart->delivery_fee = $cart->delivery_fee + $n_cart->delivery_fee;
			$n_cart->sub_total = $cart->sub_total + $n_cart->sub_total;
			$n_cart->tax_charges = $cart->tax_charges + $n_cart->tax_charges;
			$n_cart->discount_type = $cart->discount_type + $n_cart->discount_type;
			$n_cart->discount_value = $cart->discount_value + $n_cart->discount_value;
			$n_cart->discount_amount = $cart->discount_amount + $n_cart->discount_amount;
			$n_cart->order_total = $cart->order_total + $n_cart->order_total;
			$n_cart->user_id = $userID;
			$n_cart->save();


			foreach ($cart->cartdetails as $cart_detail) {
				$cart_detail->cart_id = $n_cart->id;
				foreach ($n_cart->cartdetails as $n_cartdetails) {
					if ($cart_detail->product_id === $n_cartdetails->product_id) {
						$cart_detail->quantity = $cart_detail->quantity + $n_cartdetails->quantity;
						$cart_detail->item_total = $cart_detail->item_total + $n_cartdetails->item_total;
						CartDetail::where('product_id', $n_cartdetails->product_id)->delete();
					} else {
					}
				}
				$cart_detail->save();
			}
			Cart::where('id', $cart->id)->delete();
		}

		return redirect(RouteServiceProvider::HOME);
	}
}
