<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Http\Controllers\CookieController as Cookie;

class Admin
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
        if(Auth::check() && User::isAdmin()) {
            return $next($request);
        }

        Cookie::setAlert('danger','Vous devez être administateur pour accéder à cette page');
        return redirect()->route('home');
    }
}
