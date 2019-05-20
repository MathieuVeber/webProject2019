@extends('layouts.navbar')

@section('head')
<title> Garage Azur VO | Devis & Rendez-vous </title>
@endsection

@section('content')

<div id="page" class="container">


  <div class="row">

    <div class="col-lg-3">
    </div>

    <div class="col-12 col-lg-6 justify-content-center">
      <div class="card border-info text-center">
        <h5 class="card-body text-info"> Formulaire </h5>
      </div>
    </div>

  </div>

  <div class="ajustMargin">
  </div>


<div class="row">

  <div class="col-lg-3">
  </div>


    <div class="col-12 col-lg-6 justify-content-center ajustMargin">
      <div class="card border-info">
        <div class="card-body">
          <form  method="POST" action="{{route('sendRequest',['id'=>$id])}}" enctype="multipart/form-data">
            @csrf

            <!-- car -->
            <div class="row">
                <div class="col-lg-4 col-form-label card-text text-center text-info">Voiture concernée</div>
                <div class="col-lg-8">
                  @if($cars->count() == 0)
                  <button type="button" class="btn btn-outline-info" href="#addCarCollapse"  data-toggle="collapse" aria-expanded="false" aria-controls="addCarCollapse">Ajouter</button>
                  @elseif($cars->count() == 1)
                  <input type="text" class="form-control" name="license_plate" value="{{ $cars[0]->license_plate }}" readonly>
                  @else
                  <select class="form-control" name="license_plate" placeholder="--Choisissez une voiture--" value="{{ old('license_plate')}}">
                    @foreach($cars as $car)
                      @if($car->license_plate == $selectedCar)
                    <option selected>{{$car->license_plate}}</option>
                      @else
                    <option>{{$car->license_plate}}</option>
                      @endif
                    @endforeach
                  </select>
                  @endif
              </div>
            </div>

            <div class="smallMargin">
            </div>

            <!-- problem_type -->
            <div class="row">
                <div class="col-lg-4 col-form-label card-text text-center text-info">Type de Problème</div>
                <div class="col-lg-8">
                  @if(old('problem_type')=='mechanical')
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="problem_type" value="mechanical" checked>
                    <label class="form-check-label" for="inlineCheckbox1">Mécanique</label>
                  </div>
                  @else
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="problem_type" value="mechanical">
                    <label class="form-check-label" for="inlineCheckbox1">Mécanique</label>
                  </div>
                  @endif
                  @if(old('problem_type2')=='bodyCar')
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="problem_type2" value="bodyCar" checked>
                    <label class="form-check-label" for="inlineCheckbox2">Carrosserie</label>
                  </div>
                  @else
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="problem_type2" value="bodyCar">
                    <label class="form-check-label" for="inlineCheckbox2">Carrosserie</label>
                  </div>
                  @endif
                  @if ($errors->has('problem_type'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('problem_type') }} </div> </small>
                  @endif
                </div>
            </div>

            <div class="smallMargin">
            </div>

            <!-- problem_description -->
            <div class="row">
                <div class="col-lg-4 col-form-label card-text text-center text-info">Description</div>
                <div class="col-lg-8">
                    <textarea class="form-control" id="textarea" name="problem_description" value="{{ old('problem_description') }}" rows="3"></textarea>
                    @if ($errors->has('problem_description'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('problem_description') }} </div> </small>
                    @endif
                </div>
            </div>

            <div class="smallMargin">
            </div>

            <!-- problem_picture -->
            <div class="row">
                <div class="col-lg-4 col-form-label card-text text-center text-info">Insérez une photo (.png)</div>
                <div class="col-lg-8">
                  <input type="file" class="form-control-file" id="controlFile" name="problem_picture">
                    @if ($errors->has('problem_picture'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('problem_picture') }} </div> </small>
                    @endif
                </div>
            </div>

            <div class="smallMargin">
            </div>


            <!-- problem_request -->
            <div class="row">
                <div class="col-lg-4 col-form-label card-text text-center text-info">Que désirez-vous ?</div>
                <div class="col-lg-8">
                  @if(old('problem_request')=='estimate')
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="problem_request" value="estimate" checked>
                    <label class="form-check-label" for="inlineCheckbox3">Devis</label>
                  </div>
                  @else
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="problem_request" value="estimate">
                    <label class="form-check-label" for="inlineCheckbox3">Devis</label>
                  </div>
                  @endif
                  @if(old('problem_request2')=='appointment')
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox4" name="problem_request2" value="appointment" checked>
                    <label class="form-check-label" for="inlineCheckbox4">Rendez-vous</label>
                  </div>
                  @else
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox4" name="problem_request2" value="appointment">
                    <label class="form-check-label" for="inlineCheckbox4">Rendez-vous</label>
                  </div>
                  @endif
                  @if ($errors->has('problem_request'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('problem_request') }} </div> </small>
                  @endif
                </div>
            </div>

            <div class="smallMargin">
            </div>


            <div class="row justify-content-center">
              <div class="btn-group" role="group">
                @if($cars->count() == 0)
                <button type="submit" class="btn btn-outline-info" disabled>Envoyer</button>
                @else
                <button type="submit" class="btn btn-outline-info">Envoyer</button>
                @endif
              </div>
            </div>

          </form>
        </div>
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
