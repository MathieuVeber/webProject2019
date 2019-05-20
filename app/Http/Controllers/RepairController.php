<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Repair;
use App\Http\Controllers\CookieController as Cookie;

class RepairController extends Controller
{

  public function showAllRepairs(Request $request)
  {
    $id=User::getId();
    $user=User::getUser();
    $repairs=Repair::simplePaginate(10);
    $alert=Cookie::getAlert($request);

    return view('allRepairs', ['id'=>$id, 'user'=>$user, 'repairs'=>$repairs, 'alert'=>$alert]);
  }


  public function createRepair(Request $request)
  {
    $id=User::getId();

    // Creating repair
    $currentTitle = null;
    Repair::validate($currentTitle);
    Repair::repairCreate();

    Cookie::setAlert('success','Réparation ajoutée et disponible dès maintenant !');

    return redirect()->route('allRepairs', ['id'=>$id]);
  }


  public function updateRepair(Request $request)
  {
    $id=User::getId();

    // Updating repair
    $currentTitle = Repair::where('idrepair',request('idrepair'))->firstOrFail()->title;
    Repair::validate($currentTitle);
    Repair::repairUpdate(request('idrepair'));

    Cookie::setAlert('success','Réparation actualisée');

    return redirect()->route('allRepairs', ['id'=>$id]);
  }


  public function deleteRepair(Request $request)
  {
    $id=User::getId();

    // Checking if the repair isn't bound to an invoice
    $linkedInvoices=Repair::where('repair.idrepair',request('idrepair'))
                          ->join('include','repair.idrepair','=','include.idrepair')
                          ->get();

    // Repair not deleted
    if ($linkedInvoices->count() == 1) {
      Cookie::setAlert('danger','La réparation ne peut pas être supprimée car elle est liée à une facture.');
    }
    elseif ($linkedInvoices->count() > 0) {
      Cookie::setAlert('danger','La réparation ne peut pas être supprimée car elle est liée à plusieurs factures.');
    }

    // Deleting repair
    else {
      $repairToDelete=Repair::findOrFail(request('idrepair'));
      $repairToDelete->delete();

      Cookie::setAlert('warning','La réparation a bien été supprimée');

      return redirect()->route('allRepairs', ['id'=>$id]);
    }

    // View repairs
    $user=User::getUser();
    $repairs=Repair::simplePaginate(10);

    return view('allRepairs', ['id'=>$id, 'user'=>$user, 'repairs'=>$repairs, '$linkedInvoices'=>$linkedInvoices]);
  }
}
