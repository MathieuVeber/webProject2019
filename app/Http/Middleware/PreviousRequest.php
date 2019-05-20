<?php

namespace App\Http\Middleware;

use Closure;
use \Cookie;
use Illuminate\Http\Request;

class PreviousRequest
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
      // What's the URL ?
      $route=request()->path();


      // If UserRequestController@showRequestForm <SPECIAL>
      // We'll may need the penultimate so we save both
      if ((preg_match ('#^utilisateur/\w+/contacterGarage$#', $route)) && ($request->isMethod('get')))
      {
        // If Cookie already exists
        if ($request->cookie('lastRequest')) {
          // cookie : [last, secondToLast]
          $lastCookie=$request->cookie('lastRequest');
          $lastRoute=json_decode($lastCookie)->last;

          $cookieToSet=collect(['last'=>$route, 'secondToLast'=>$lastRoute])->toJson();

          Cookie::queue(Cookie::forget('lastRequest'));
          Cookie::queue('lastRequest',$cookieToSet,30);
        }

        // Or Cookie must be created
        else {
          // cookie : [last]
          $cookieToSet=collect(['last'=>$route])->toJson();
          Cookie::queue('lastRequest', $cookieToSet, 30);
        }
      }

      /*
      // If UserRequestController@sendRequest <SPECIAL>
      // We actually need the penultimate so we act like it was the usual lastRequest
      elseif ( preg_match ('#^utilisateur/\w+/contacterGarage$#', $route) && $request->isMethod('post') )
      {
        // cookie : [secondToLast] | The cookie exists already
        $lastCookie=$request->cookie('lastRequest');
        $secondToLastRoute=json_decode($lastCookie)->secondToLast;

        $cookieToSet=collect(['last'=>$secondToLastRoute])->toJson();

        Cookie::queue(Cookie::forget('lastRequest'));
        Cookie::queue('lastRequest',$cookieToSet,30);
      }
      */


      // All other cases <USUAL>
      // We may need the last request so we save it !
      else
      {
        // cookie : [last]
        $cookieToSet=collect(['last'=>$route])->toJson();

        // If Cookie already exists
        if ($request->cookie('lastRequest')) {
          Cookie::queue(Cookie::forget('lastRequest'));
          Cookie::queue('lastRequest',$cookieToSet,30);
        }
        // Or Cookie must be created
        else {
          Cookie::queue('lastRequest', $cookieToSet, 30);
        }
      }


      return $next($request);
    }
}
