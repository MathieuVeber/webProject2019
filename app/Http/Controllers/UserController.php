<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Car;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CookieController as Cookie;

class UserController extends Controller
{

  public function showProfile(Request $request)
  {
    $id=User::getId();
    $user=User::getUser();
    $cars=Car::getUserCars($user->id);
    $alert=Cookie::getAlert($request);

    return view('profile', ['id'=>$id, 'user'=>$user, 'cars'=>$cars, 'alert'=>$alert]);
  }


  public function updateProfile(Request $request)
  {
    $id=User::getId();

    // Updating profile
    User::validateUpdate();
    User::userUpdate();

    Cookie::setAlert('success','Profil actualisé');

    return redirect()->route('profile', ['id'=>$id]);
  }


  public function deleteProfile(Request $request)
  {
    // Potentially deleting the picture of the estimate (remaining data will be deleted thanks to a cascade)
    $cars = Car::where('license_plate', request('license_plate'))->get();
    foreach ($cars as $car) {
      $path = $car->problem_picture;
      if ($path != null) {
        Storage::delete($path);
      }
    }

    $user=User::getUser();
    Auth::logout();
    $user->delete();

    Cookie::setAlert('warning','Toutes vos données ont bien été supprimées');

    return redirect()->route('home');
  }

}
