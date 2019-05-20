<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Http\Controllers\CookieController as Cookie;

class BasicUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check() && !User::isAdmin()) {
            return $next($request);
        }

        Cookie::setAlert('danger','Voyons... Cette page est destinée aux clients !');
        return redirect()->route('home');
    }
}
