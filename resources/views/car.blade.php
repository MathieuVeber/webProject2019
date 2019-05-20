@extends('layouts.navbar')

@section('head')
<title> Garage Azur VO | Véhicule {{$car->license_plate}} </title>
@endsection

@section('content')

<div id="page" class="container">

  @if($user->id == $car->owner)
  <div class="row ajustMargin">

    <div class="col-lg-3">
    </div>

    <div class="col-12 col-lg-6 justify-content-center">
      <div class="card border-info text-center">
        <a class="aInCard" href="{{route('profile',['id'=>$id])}}">
        <h5 class="card-body text-info"> Revenir à mon Espace </h5>
        </a>
      </div>
    </div>

  </div>
  @endif

  <div class="row">

    <div class="col-lg-3">
    </div>


    <!-- Show Car -->

    <div class="col-12 col-lg-6 justify-content-center" id="showProfile">
      <div class="card bg-info">
        <h5 class="card-header text-white text-center"> {{$car->license_plate}} </h5>
        <div class="card-body">
          @if(($user->admin) && ($user->id != $car->owner))
          <p class="card-text text-center text-white">Propriétaire : {{$owner->email}}</p>
          <p class="card-text text-center text-white">Contact : 0{{$owner->phone}}</p>
          @endif
          <p class="card-text text-center text-white">Modèle : {{$car->model}}</p>
          <p class="card-text text-center text-white">Marque : {{$car->make}}</p>
          <p class="card-text text-center text-white">Année de Sortie : {{$car->year}}</p>
          <p class="card-text text-center text-white">Mise en Circulation : {{$car->firstRegistration}}</p>

          <div class="row justify-content-center">
            <div class="btn-group" role="group">
              @if(($user->admin) && ($user->id == $car->owner))
              <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownOptions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Options
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownOptions">
                  <form method='post' action='{{route("forSale",["id"=>$id, "license_plate"=>$car->license_plate])}}'>
                    @csrf
                    @method('put')
                    @if($car->forSale)
                    <button type="submit" class="dropdown-item btn btn-default">Annuler la Vente</button>
                    @else
                    <button type="submit" class="dropdown-item btn btn-default">Mettre en Vente</button>
                    @endif
                  </form>
                  <button class="dropdown-item btn btn-default" data-toggle="modal" data-target="#soldCarModal">Vendre</button>
                </div>
              </div>

              @elseif(!$user->admin)
              <a role="button" href="{{route('request', ['id'=>$id, 'selectedCar'=>$car->license_plate])}}" class="btn-default btn text-light btn-warning">Un Problème ?</a>
              @endif
              @if($user->id == $car->owner)
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteCarModal">Supprimer</button>
              @endif
            </div>
          </div>

          <!-- Modal Sold -->
          <div class="modal fade" id="soldCarModal" tabindex="-1" role="dialog" aria-labelledby="soldCarTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <form method='post' action='{{route("soldCar",["id"=>$id, "license_plate"=>$car->license_plate])}}'>
                  @csrf
                  @method('put')
                <div class="modal-header">
                  <h5 class="modal-title" id="soldCarTitle">Vendre mon véhicule</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body text-center">
                  Pour effectuer le changement de propriétaire, veuillez fournir son email :
                  <div class="smallMargin">
                  </div>
                  <!-- email new owner -->
                  <div class="row">
                    <div class="col-lg-3">
                    </div>
                    <div class="col-6">
                    <input type="email" class="form-control" name="newOwner" placeholder="nouveau@propriétaire.com" value="{{ old('newOwner') }}">
                    @if ($errors->has('newOwner'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('newOwner') }} </div> </small>
                    @endif
                  </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-center btn-info">Vendre</button>
                </div>
              </form>
              </div>
            </div>
          </div>

          <!-- Modal Delete -->
          <div class="modal fade" id="deleteCarModal" tabindex="-1" role="dialog" aria-labelledby="deleteCarTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="deleteCarTitle">Supprimer mon véhicule</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Cette action entraîne la suppression définitive de votre véhicule ainsi que toutes les données qui y sont rattachées telles que ses factures et demande de devis.
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-info" data-dismiss="modal">Annuler</button>
                  <form method='post' action='{{route("deleteCar",["id"=>$id, "license_plate"=>$car->license_plate])}}'>
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-center btn-danger">Supprimer le véhicule</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>

  <div class="ajustMargin">
  </div>

  <div class="row">

    <div class="col-lg-3">
    </div>

    <div class="col-12 col-lg-6 justify-content-center">
      <div class="card border-info text-center">
        @if($invoices->count() == 0)
        <h5 class="card-body text-info"> Vous n'avez encore aucune facture... </h5>
        @elseif($invoices->count() == 1)
        <h5 class="card-body text-info"> Ma Facture </h5>
        @else
        <h5 class="card-body text-info"> Mes Factures </h5>
        @endif
      </div>
    </div>

  </div>

  <div class="ajustMargin">
  </div>

  @foreach($invoices as $invoice)


  <div class="row ajustMargin">

    <div class="col-lg-3">
    </div>

        <div class="col-12 col-md-6 ajustMargin">
        <div class="card border-info">
            <h5 class="card-header text-info text-center">Facture n°{{$invoice->idInvoice}}</h5>
            <div class="card-body">
              <p class="card-text text-center text-info">Date : {{$invoice->created_at}}</p>
              <?php $id=$invoice->idInvoice?>
              @foreach($includes[$id] as $include)
              <p class="card-text text-center text-info">Réparation : {{--$include->title--}}</p>
              <p class="card-text text-center text-info">Main d'oeuvre : {{--$include->laborCost--}}€</p>
              <p class="card-text text-center text-info">Pièces et équipements : {{--$include->technicalCost--}}€</p>
              @endforeach

              <div class="row justify-content-center">
                <div class="btn-group" role="group">
                  @if($user->admin)
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteInvoiceModal">Supprimer</button>
                  @endif
                </div>
              </div>

              <!-- Modal -->
              <div class="modal fade" id="deleteInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="deleteInvoiceTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="deleteInvoiceTitle">Supprimer la facture</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Cette action entraîne la suppression définitive de la facture.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-info" data-dismiss="modal">Annuler</button>
                      <form method='post' action='{{route("deleteInvoice",["idInvoice"=>$invoice->idInvoice, "license_plate"=>$car->license_plate])}}'>
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-center btn-danger">Supprimer cette facture</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
      </div>
      @endforeach



  @if($user->admin)
  <div class="row ajustMargin">

    <div class="col-lg-3">
    </div>

    <div class="col-12 col-lg-6 justify-content-center">
      <div class="card bg-info text-center">
        <a class="aInCard" href="#addCarCollapse" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="addCarCollapse">
        <h5 class="card-body text-white"> Ajouter une Facture </h5>
        </a>
      </div>
    </div>

  </div>

  <div class="collapse" id="addCarCollapse">
  <div class="row">

    <div class="col-lg-3">
    </div>


      <div class="col-12 col-lg-6 justify-content-center ajustMargin">
        <div class="card bg-info">
          <div class="card-body">
            <form  method="POST" action="{{route('createInvoice', ['license_plate'=>$car->license_plate])}}">
              @csrf

              <div id="allRepairs">
              @if(old('counter') != null )
              <input id="counter" type="hidden" name="counter" value="{{old('counter')}}">
                <?php $counter2 = (int) old('counter') ?>
              @else
              <input id="counter" type="hidden" name="counter" value="1">
                <?php $counter2 = 1 ?>
              @endif

              @for($i = 1; $i < (int)1 + (int)$counter2 ; $i++)

              <div id="repair{{$i}}">

              <!-- repair -->
              <div class="row">
                  <div class="col-lg-4 col-form-label card-text text-center text-white">Réparation</div>
                  <div class="col-lg-8">
                    <select id="selectRepair" class="form-control" name="repair{{$i}}" placeholder="--Choisissez une réparation--" value="{{ old('repair'.$i)}}">
                      @foreach($repairs as $repair)
                      <option>{{$repair}}</option>
                      @endforeach
                    </select>
                  </div>
              </div>


              <!-- laborCost -->
              <div class="row">
                  <div class="col-lg-4 col-form-label card-text text-center text-white">Main d'oeuvre TTC €</div>
                  <div class="col-lg-8">
                      <input type="number" class="form-control" name="laborCost{{$i}}" placeholder="45.00" value="{{ old('laborCost'.$i) }}">
                      @if ($errors->has('laborCost'.$i))
                          <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('laborCost'.$i) }} </div> </small>
                      @endif
                  </div>
              </div>

              <!-- technicalCost -->
              <div class="row smallMargin">
                  <div class="col-lg-4 col-form-label card-text text-center text-white">Pièces TTC €</div>
                  <div class="col-lg-8">
                      <input type="number" class="form-control" name="technicalCost{{$i}}" placeholder="94.56" value="{{ old('technicalCost'.$i) }}">
                      @if ($errors->has('technicalCost'.$i))
                          <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('technicalCost'.$i) }} </div> </small>
                      @endif
                  </div>
              </div>

              <div class="smallMargin">
              </div>

            </div>
            @endfor
            </div>


              <div class="row justify-content-center">
                <div class="btn-group" role="group">
                  <button type="button" onclick="addRepair()" class="btn btn-outline-light">Ajouter une réparation</button>
                  <button type="submit" class="btn btn-light text-info">Enregistrer la facture</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>

    </div>
    @endif
  </div>

</div>
@endsection
