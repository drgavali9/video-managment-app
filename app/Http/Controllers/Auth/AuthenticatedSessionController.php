<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Frontend\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\User;
use App\Models\UserAccount;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class AuthenticatedSessionController extends BaseController
{
	/**
	 * Display the login view.
	 *
	 * @return View
	 */
	public function index()
	{
		return view('admin.login.index');
	}

	public function create()
	{
		return view('auth.login');
	}

	/**
	 * Handle an incoming authentication request.
	 *
	 * @param LoginRequest $request
	 * @return RedirectResponse
	 */
	public function store(LoginRequest $request)
	{
		$request->authenticate();
		$request->session()->regenerate();

		$user = User::find(auth()->user()->id);
		if ($user->is_admin === 1) {
			return redirect()->intended(RouteServiceProvider::ADMIN);
		}

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
		return redirect()->intended(RouteServiceProvider::HOME);
	}


	public function checkUser(Request $request)
	{
		$user = User::where('email', $request->email)->first();
		if (isset($user)) {
			if ($user->password != null) {
				return response()->json([
					'status' => true,
					'success' => true,
					'message' => 'User data get.',
				]);
			} else if ($user->password == null) {
				$userAccount = UserAccount::where('user_id', $user->id)->first();
				if ($userAccount != null) {
					return response()->json([
						'status' => false,
						'success' => false,
						'message' => 'Please login with social account.',
					]);
				} else {
					$status = Password::sendResetLink(
						$request->only('email')
					);

					$status == Password::RESET_LINK_SENT
						? back()->with('status', __($status))
						: back()->withInput($request->only('email'))
						->withErrors(['email' => __($status)]);

					return response()->json([
						'status' => false,
						'success' => false,
						'message' => 'Due to upgrade system we reset your password, Please check your mail and reset your password.',
					]);
				}
			}
		} else {
			return response()->json([
				'status' => false,
				'success' => false,
				'message' => 'These credentials do not match our records.',
			]);
		}
	}

	/**
	 * Destroy an authenticated session.
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function destroy(Request $request)
	{
		Auth::guard('web')->logout();

		$request->session()->invalidate();

		$request->session()->regenerateToken();

		return redirect('/');
	}
}
