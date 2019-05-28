<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Car;
use App\Http\Controllers\CookieController as Cookie;

class HomeController extends Controller
{

  public function show(Request $request)
  {
    $id=User::getId();
    if ($id != null) {
      $user=User::getUser();
    }
    else {
      $user=null;
    }
    $forSale=Car::where('forSale',true)
                ->join('user','car.owner','=','user.id')
                ->where('admin',true)
                ->inRandomOrder()
                ->take(3)
                ->get();

    $alert=Cookie::getAlert($request);

  return view('home',['id'=>$id, 'user'=>$user, 'forSale'=>$forSale, 'alert'=>$alert]);
  }


  public function notFound(Request $request)
  {
    $page=request()->path();
    Cookie::setAlert('danger','Saperlipopette, la page '.$page.' est introuvable... Retour au point de départ !');

    return redirect()->route('home');
  }

}
