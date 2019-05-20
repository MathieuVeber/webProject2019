<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Car;
use App\Http\Controllers\CookieController as Cookie;
use Illuminate\Support\Facades\Storage;

class UserRequestController extends Controller
{

  public function showRequestForm(Request $request)
  {
    $id=User::getId();
    $user=User::getUser();
    $cars=Car::getUserCars($user->id);
    if(request()->has('selectedCar')) {
      $selectedCar=request('selectedCar');
    }
    else {
      $selectedCar=null;
    }

    return view('request', ['id'=>$id, 'user'=>$user, 'cars'=>$cars, 'selectedCar'=>$selectedCar]);
  }


  public function sendRequest(Request $request)
  {
    $user=User::getUser();
    $permission = Car::where('owner', $user->id)->where('license_plate', request('license_plate'))->count();
    if (!$permission) {
      Cookie::setAlert('danger',"Vous ne pouvez pas renseigner une voiture qui ne vous appartient pas !");
      return redirect()->route('home');
    }

    request()->validate([
        'problem_type' => ['string'],
        'problem_type2' => ['string'],
        'problem_request' => ['string'],
        'problem_request2' => ['string'],
        'problem_description' => ['bail','required','string'],
        'problem_picture' => ['bail','required','image'],
    ]);

    if (request('problem_type')=='mechanical' && request('problem_type2')=='bodyCar') {
      $type='both';
    }
    elseif (request('problem_type')=='mechanical') {
      $type='mechanical';
    }
    else {
      $type='bodyCar';
    }

    if (request('problem_request')=='estimate' && request('problem_request2')=='appointment') {
      $pblRequest='both';
    }
    elseif (request('problem_request')=='estimate') {
      $pblRequest='estimate';
    }
    else {
      $pblRequest='appointment';
    }

    $picturePath = Storage::putFile('public', $request->file('problem_picture'));

    Car::problemUpdate(request('license_plate'),$type,$pblRequest,request('problem_description'),$picturePath);

    Cookie::setAlert('success','Votre requête sera traitée dans les plus brefs délais');
    $route=Cookie::getBack($request);

    return redirect($route);
  }


  public function showAllRequests(Request $request)
  {
    $id=User::getId();
    $user=User::getUser();
    $carsWithProblems=Car::whereNotNull('problem_type')
                         ->join('user','car.owner','=','user.id')
                         ->orderBy('car.updated_at','desc')
                         ->simplePaginate(5);

    //foreach ($carsWithProblems as $car) {
    //  $car->problem_picture=Storage::url($car->problem_picture);
    //}

    return view('allRequests',['id'=>$id, 'user'=>$user, 'cars'=>$carsWithProblems]);
  }

}

// à implémenter :
/*
si request depuis show car alors selectedCar
si recherche admin null alors json <!>
*/
