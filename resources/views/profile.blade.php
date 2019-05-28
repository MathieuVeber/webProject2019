@extends('layouts.navbar')

@section('head')
<title> Garage Azur VO | Mon Espace </title>
@endsection

@section('content')

<div id="page" class="container">

  <div class="row">

    <div class="col-lg-3">
    </div>


    <!-- Show Profile -->

    <div class="col-12 col-lg-6 justify-content-center" id="showProfile">
      <div class="card border-info">
        <h5 class="card-header text-info"> Mes Coordonnées </h5>
        <div class="card-body">
          @if($user->gender == 'M')
          <h5 class="card-title text-info text-center">M. {{$user->firstName}}  {{$user->lastName}}</h5>
          @else
          <h5 class="card-title text-info text-center">Mme. {{$user->firstName}}  {{$user->lastName}}</h5>
          @endif
          <p class="card-text text-center text-info">Adresse email   : {{$user->email}}</p>
          <p class="card-text text-center text-info">N° de Téléphone : 0{{$user->phone}}</p>
          <p class="card-text text-center text-info">Code Postal     : {{$user->zipCode}}</p>

          <div class="row justify-content-center">
            <div class="btn-group" role="group">
              <button type="button" onclick="transFormProfile()" class="btn btn-outline-warning">Mettre à Jour</button>
              @if($user->admin)
              <form method='post' action='{{route("logout",["id"=>$id])}}'>
                @csrf
                <button type="submit" class="btn btn-center btn-outline-danger">Se Déconnecter</button>
              </form>
              @else
              <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteProfileModal">Se Désinscrire</button>
              @endif
            </div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="deleteProfileModal" tabindex="-1" role="dialog" aria-labelledby="deleteProfileTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="deleteProfileTitle">Se Désinscrire</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Cette action entraîne la suppression définitive de votre profil ainsi que toutes les données qui y sont rattachées telles que vos véhicules, leurs factures et demande de devis.
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-info" data-dismiss="modal">Annuler</button>
                  <form method='post' action='{{route("deleteProfile",["id"=>$id])}}'>
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-center btn-danger">Supprimer mon Compte</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Update Profile -->

    <div class="col-12 col-lg-6 justify-content-center" id="formProfile" style="display:none;">
      <div class="card border-info">
        <h5 class="card-header text-info"> Mettre à Jour </h5>
        <div class="card-body">
          <form  method="post" action='{{route("updateProfile",["id"=>$user->id])}}'>
            @csrf
            @method('put')

            <!-- email -->
            <div class="row">
                <div class="col-lg-4 col-form-label card-text text-center text-info">Email</div>
                <div class="col-lg-8">
                    <input type="email" class="form-control" name="email" value="{{ $user->email }}" readonly>
                </div>
            </div>

            <div class="smallMargin">
            </div>

            <!-- firstName -->
            <div class="row">
                <div class="col-lg-4 col-form-label card-text text-center text-info">Prénom</div>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="firstName" value="{{ $user->firstName }}">
                    @if ($errors->has('firstName'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('firstName') }} </div> </small>
                    @endif
                </div>
            </div>

            <div class="smallMargin">
            </div>

            <!-- lastName -->
            <div class="row">
                <div class="col-lg-4 col-form-label card-text text-center text-info">Nom</div>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="lastName" value="{{ $user->lastName }}">
                    @if ($errors->has('lastName'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('lastName') }} </div> </small>
                    @endif
                </div>
            </div>

            <div class="smallMargin">
            </div>

            <!-- phone -->
            <div class="row">
                <div class="col-lg-4 col-form-label card-text text-center text-info">Téléphone</div>
                <div class="col-lg-8">
                    <input type="number" class="form-control" name="phone" value="0{{ $user->phone }}">
                    @if ($errors->has('phone'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('phone') }} </div> </small>
                    @endif
                </div>
            </div>

            <div class="smallMargin">
            </div>

            <!-- zipCode -->
            <div class="row smallMargin">
                <div class="col-lg-4 col-form-label card-text text-center text-info">Code Postal</div>
                <div class="col-lg-8">
                    <input type="number" class="form-control" name="zipCode" value="{{ $user->zipCode }}">
                    @if ($errors->has('zipCode'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('zipCode') }} </div> </small>
                    @endif
                </div>
            </div>

            <div class="smallMargin">
            </div>

            <div class="row justify-content-center">
              <div class="btn-group" role="group">
                <button type="button" onclick="transFormProfile()" class="btn btn-outline-warning">Annuler</button>
                <button type="submit" class="btn btn-outline-info">Valider</button>
              </div>
            </div>

          </form>
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
      <div class="card bg-info text-center">
        @if($cars->count() == 0)
        <h5 class="card-body text-white"> Vous n'avez encore aucun véhicule... </h5>
        @elseif($cars->count() == 1)
        <h5 class="card-body text-white"> Mon Véhicule </h5>
        @else
        <h5 class="card-body text-white"> Mes Véhicules </h5>
        @endif
      </div>
    </div>

  </div>

  <div class="ajustMargin">
  </div>

  <div class="row">

    <div class="col justify-content-center">
      <div class="card-deck">

        @if($cars->count() == 1)
        <div class="col-md-3 col-lg-4 ajustMargin"></div>
        @elseif($cars->count() == 2)
        <div class="col-lg-2 ajustMargin"></div>
        @endif

        @foreach($cars as $car)
        <div class="col-12 col-md-6 col-lg-4 ajustMargin">
        <div class="card bg-info">
          <a href="{{route('car', ['id'=>$id, 'license_plate'=>$car->license_plate])}}" class="aInCard">
            <h5 class="card-header text-white text-center">{{$car->license_plate}}</h5>
            <div class="card-body">
              <p class="card-text text-center text-white">Modèle : {{$car->model}}</p>
              <p class="card-text text-center text-white">Marque : {{$car->make}}</p>
              <p class="card-text text-center text-white">Année de sortie : {{$car->year}}</p>
              <p class="card-text text-center text-white">Mise en circulation : {{$car->firstRegistration}}</p>

              <div class="row justify-content-center">
                <div class="btn-group" role="group">
                  @if($user->admin)
                  <form method='post' action='{{route("forSale",["id"=>$id, "license_plate"=>$car->license_plate])}}'>
                    @csrf
                    @method('put')

                    @if($car->forSale)
                  <button type="submit" class="btn btn-light">Annuler la Vente</button>

                    @else
                  <button type="submit" class="btn btn-light">Mettre en Vente</button>
                    @endif
                  </form>
                  @endif
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteCarModal">Supprimer</button>
                </div>
              </div>

              <!-- Modal -->
              <div class="modal fade" id="deleteCarModal" tabindex="-1" role="dialog" aria-labelledby="deleteCarTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="deleteCarTitle">Supprimer le véhicule</h5>
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
                        <button type="submit" class="btn btn-center btn-danger">Supprimer ce Véhicule</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
</div>

        @endforeach
      </div>
    </div>

  </div>



  <div class="row ajustMargin">

    <div class="col-lg-3">
    </div>

    <div class="col-12 col-lg-6 justify-content-center">
      <div class="card border-info text-center">
        <a class="aInCard" href="#addCarCollapse" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="addCarCollapse">
        <h5 class="card-body text-info"> Ajouter un Véhicule </h5>
        </a>
      </div>
    </div>

  </div>

  <div class="collapse" id="addCarCollapse">
  <div class="row">

    <div class="col-lg-3">
    </div>


      <div class="col-12 col-lg-6 justify-content-center ajustMargin">
        <div class="card border-info">
          <div class="card-body">
            <form  method="POST" action="{{route('addCar',['id'=>$id])}}">
              @csrf

              <!-- license_plate -->
              <div class="row">
                  <div class="col-lg-4 col-form-label card-text text-center text-info">Immatriculation</div>
                  <div class="col-lg-8">
                      <input type="text" class="form-control" name="license_plate" placeholder="AX-807-CE" value="{{ old('license_plate') }}">
                      @if ($errors->has('license_plate'))
                          <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('license_plate') }} </div> </small>
                      @endif
                  </div>
              </div>

              <div class="smallMargin">
              </div>

              <!-- model -->
              <div class="row">
                  <div class="col-lg-4 col-form-label card-text text-center text-info">Modèle</div>
                  <div class="col-lg-8">
                      <input type="text" class="form-control" name="model" placeholder="Twingo" value="{{ old('model') }}">
                      @if ($errors->has('model'))
                          <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('model') }} </div> </small>
                      @endif
                  </div>
              </div>

              <div class="smallMargin">
              </div>

              <!-- make -->
              <div class="row">
                  <div class="col-lg-4 col-form-label card-text text-center text-info">Marque</div>
                  <div class="col-lg-8">
                      <input type="text" class="form-control" name="make" placeholder="Renault" value="{{ old('make') }}">
                      @if ($errors->has('make'))
                          <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('make') }} </div> </small>
                      @endif
                  </div>
              </div>

              <div class="smallMargin">
              </div>

              <!-- year -->
              <div class="row">
                  <div class="col-lg-4 col-form-label card-text text-center text-info">Année de Sortie</div>
                  <div class="col-lg-8">
                      <input type="number" class="form-control" name="year" placeholder="2009" value="{{ old('year') }}">
                      @if ($errors->has('year'))
                          <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('year') }} </div> </small>
                      @endif
                  </div>
              </div>

              <div class="smallMargin">
              </div>

              <!-- firstRegistration -->
              <div class="row smallMargin">
                  <div class="col-lg-4 col-form-label card-text text-center text-info">Mise en Circulation</div>
                  <div class="col-lg-8">
                      <input type="number" class="form-control" name="firstRegistration" placeholder="2011" value="{{ old('firstRegistration') }}">
                      @if ($errors->has('firstRegistration'))
                          <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('firstRegistration') }} </div> </small>
                      @endif
                  </div>
              </div>

              <div class="smallMargin">
              </div>

              <div class="row justify-content-center">
                <div class="btn-group" role="group">
                  <button type="submit" class="btn btn-outline-info">Ajouter</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>
@endsection
