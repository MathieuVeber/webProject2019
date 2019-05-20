<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Cookie;

class CookieController extends Controller
{

  public static function setAlert($type,$message)
  {
    $alert=collect(['type'=>$type, 'message'=>$message])->toJson();
    Cookie::queue('alert', $alert, 3);
  }


  public static function getAlert(Request $request)
  {
    if ($request->cookie('alert')) {
      $alert=$request->cookie('alert');
      $alert=json_decode($alert);
      Cookie::queue(Cookie::forget('alert'));
    }

    else{
      $alert=null;
    }

    return $alert;
  }


  public static function getBack(Request $request)
  {
    if ($request->cookie('lastRequest')) {
      $lastRequest=$request->cookie('lastRequest');
      $lastRoute=json_decode($lastRequest)->last;
      $lastRoute='/'.$lastRoute;
      Cookie::queue(Cookie::forget('lastRequest'));
    }

    else{
      $lastRoute='/accueil';
    }

    return $lastRoute;
  }

}
