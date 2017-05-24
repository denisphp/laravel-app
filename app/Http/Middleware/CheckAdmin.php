<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdmin
{
    public function handle($request, Closure $next)
    {
        if (auth()->guard('admin')->id()) {
            return $next($request);
        }

        return redirect()->intended('admin/login/')->with('status', 'Please Login to access admin area');
    }
}
