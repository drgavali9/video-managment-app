<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuthenticate
{
	public function handle(Request $request, Closure $next)
	{
		if ($request->user()->is_admin == 1) {
			return $next($request);
		}
		return redirect()->route('login');
	}
}
