<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Car;
use App\Invoice;
use App\Included;
use App\Repair;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CookieController as Cookie;
use Illuminate\Support\Facades\Storage;


class CarController extends Controller
{

  public function addCar(Request $request)
  {
    $id=User::getId();

    // Adding car
    Car::validateCreate();
    $newCar=Car::carCreate(Auth::id())->license_plate;

    Cookie::setAlert('success','Voiture ajoutée');
    $route=Cookie::getBack($request);
    $routeUserRequest='/'.'utilisateur/'.$id.'/contacterGarage';

    if ($route == $routeUserRequest) {
      return redirect($route)->with(['id'=>$id, 'selectedCar'=>$newCar]);
    }

    return redirect()->route('profile', ['id'=>$id]);
  }


  public function showCar(Request $request)
  {
    $id=User::getId();
    $user=User::getUser();
    if (!$user->admin) {
      $permission = Car::where('owner', $user->id)->where('license_plate', request('license_plate'))->count();
      if (!$permission) {
        Cookie::setAlert('danger',"Vous ne pouvez pas consulter une voiture qui ne vous appartient pas !");
        return redirect()->route('home');
      }
    }

    $car=Car::findOrFail(request('license_plate'));
    $owner=User::where('id', $car->owner)->firstOrFail();
    $invoices=Invoice::where('car',$car->license_plate)->get();
    $includes=Included::getCarInvoices($invoices);
    $repairs=Repair::pluck('title');
    $alert=Cookie::getAlert($request);

    return view('car', ['id'=>$id, 'user'=>$user, 'car'=>$car, 'invoices'=>$invoices, 'includes'=>$includes, 'alert'=>$alert, 'repairs'=>$repairs, 'owner'=>$owner]);
  }


  public function deleteCar(Request $request)
  {
    $id=User::getId();
    $user=User::getUser();
    $permission = Car::where('owner', $user->id)->where('license_plate', request('license_plate'))->count();
    if (!$permission) {
      Cookie::setAlert('danger',"Vous ne pouvez pas supprimer une voiture qui ne vous appartient pas !");
      return redirect()->route('home');
    }

    // Potentially deleting the picture of the estimate
    $path = Car::where('license_plate', request('license_plate'))->firstOrFail()->problem_picture;
    if ($path != null) {
      Storage::delete($path);
    }

    // Deleting car
    $carToDelete=Car::findOrFail(request('license_plate'));
    $carToDelete->delete();

    Cookie::setAlert('warning','La voiture et ses factures ont bien été supprimées');

    return redirect()->route('profile', ['id'=>$id]);
  }


  public function updateCarForSale(Request $request)
  {
    // Updating car
    $car=Car::findOrFail(request('license_plate'));
    $forSale = ($car->forSale) ? false : true ;
    Car::saleUpdate(request('license_plate'),$forSale);

    Cookie::setAlert('success','Mise en vente actualisée');
    $route=Cookie::getBack($request);

    return redirect($route);
  }


  public function updateSoldCar(Request $request)
  {
    $id=User::getId();

    // Updating car
    request()->validate(['newOwner' => ['bail','required','email','exists:user,email']]);
    $newOwnerId=User::where('email', request('newOwner'))->firstOrFail()->id;
    Car::soldUpdate(request('license_plate'),$newOwnerId);

    Cookie::setAlert('success','Voiture vendue avec succès');

    return redirect()->route('profile', ['id'=>$id]);
  }


  public function search(Request $request)
  {
    $id=User::getId();

    $search=request('license_plate');

    if ($search == 'tous') {
      $results = Car::simplePaginate(6);
    }
    else {
      $results=Car::when(!empty($search), function ($query) use ($search) { return $query
                  ->where('license_plate', 'like', '%' . $search . '%');})
                  ->simplePaginate(6);
    }

    // No Result -> Back home
    if ($results->count() == 0) {
      Cookie::setAlert('danger','Aucune voiture répertoriée ne correspond à cette immatriculation...');

      return redirect()->route('home');
    }

    // 1 Result -> View car with its invoices
    elseif ($results->count() == 1) {
      $license_plate=$results->first()->license_plate;
      return redirect()->route('adminCar', ['id'=>$id, 'license_plate'=>$license_plate]);
    }

    // Multiple Result -> View search
    else {
      $user=User::getUser();

      return view('search', ['id'=>$id, 'user'=>$user, 'cars'=>$results, 'license_plate'=>$search]);
    }
  }

  // To see all cars from an user go to UserController@showProfile
}
