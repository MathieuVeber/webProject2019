<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Car;
use App\Invoice;
use App\Repair;
use App\Included;
use App\Http\Controllers\CookieController as Cookie;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{

  public function createInvoice(Request $request)
  {
    $id=User::getId();

    // Checking before anything else
    Invoice::validateCreate($request);
    for ($i=1; $i < request('counter') + 1 ; $i++) {
      Included::validateCreate();
    }

    // Creating invoice and include (which means the prices)
    //$idInvoice = Invoice::invoiceCreate(request('license_plate'))->idInvoice;

    for ($i=1; $i < 1 + (int) request('counter') ; $i++) {
      //$idrepair = Repair::where('title', request('repair'.$i))->firstOrFail()->idrepair;
      Included::includeCreate(4, 3, 1);
      dd('f');
    }
    dd('r');
    // Potentially deleting the picture of the estimate (remaining data will be deleted thanks to a trigger)
    $path = Car::where('license_plate', request('license_plate'))->firstOrFail()->problem_picture;
    if ($path != null) {
      Storage::delete($path);
    }

    Cookie::setAlert('success','La facture a bien été ajoutée !');

    redirect()->route('car', ['id'=>$id, 'license_plate'=>request('license_plate')]);
  }


  public function deleteInvoice(Request $request)
  {
    $id=User::getId();

    // Deleting invoice
    $invoiceToDelete=Invoice::findOrFail(request('idInvoice'));
    $invoiceToDelete->delete();

    Cookie::setAlert('warning','La facture a bien été supprimée');

    redirect()->route('car', ['id'=>$id, 'license_plate'=>request('license_plate')]);
  }

  // To see all invoices from a car go to CarController@showCar
}
