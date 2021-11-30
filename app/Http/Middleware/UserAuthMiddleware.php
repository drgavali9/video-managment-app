<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAuthMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next)
	{
		if ($request->user() && $request->user()->is_admin == 1) {
			$request->session()->flash('error', 'Unauthorized access');
			auth()->logout();
			return redirect()->route('login');
		}
		if (!empty(auth()->user())) {
			if (empty(auth()->user()->first_name) && empty(auth()->user()->last_name) && !$request->is('profile*') && !$request->is('logout') && !request('profile/{email}')) {
				$request->session()->flash('error', 'Please complate your profile.');
				return redirect()->route('profile');
			}
			/* elseif (empty(auth()->user()->first_name) && empty(auth()->user()->last_name) && $request->is('profile') && !$request->is('logout')) {
				if(!$request->is('profile/{email}') && !$request->is('/profile?tab=profile1'))
				{
					$request->session()->flash('error', 'Please complate your profile.');
				}

			}*/
		}
		return $next($request);
	}
}
