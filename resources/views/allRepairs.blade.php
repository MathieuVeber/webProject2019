@extends('layouts.navbar')

@section('head')
<title> Garage Azur VO | Réparations </title>
@endsection

@section('content')

<div id="page" class="container">

  <div class="row">

    <div class="col-lg-3">
    </div>

    <div class="col-12 col-lg-6 justify-content-center">
      <div class="card bg-info text-center">
        @if($repairs->count() == 0)
        <h5 class="card-body text-white"> Aucune réparation pour le moment... </h5>
        @else
        <h5 class="card-body text-white"> Réparations </h5>
        @endif
      </div>
    </div>

  </div>

  <div class="ajustMargin">
  </div>

  @foreach($repairs as $repair)


  <div class="row">

    <div class="col-lg-3">
    </div>
        <!-- show repair -->

        <div class="col-12 col-lg-6 ajustMargin" id="{{'show'.($repair->idrepair)}}" style="display:block;">
        <div class="card bg-info">
            <h5 class="card-header text-white text-center">{{$repair->title}}</h5>
            <div class="card-body">
              @if($repair->type == 'mechanical')
              <p class="card-text text-center text-white">Type : Mécanique</p>
              @else
              <p class="card-text text-center text-white">Type : Carrosserie</p>
              @endif
              <p class="card-text text-center text-white">Description : {{$repair->description}}</p>
              <div class="row justify-content-center">
                <div class="btn-group" role="group">
                  <button type="button" onclick="transForm('{{'show'.($repair->idrepair)}}','{{'form'.($repair->idrepair)}}')" class="btn btn-warning">Modifier</button>
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteRepairModal">Supprimer</button>
                </div>
              </div>

              <!-- Delete Modal -->
              <div class="modal fade" id="deleteRepairModal" tabindex="-1" role="dialog" aria-labelledby="deleteRepairTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="deleteRepairTitle">Supprimer la réparation</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Cette action entraîne la suppression de la réparation à condition qu'aucune facture ne soit reliée à celle-ci.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-info" data-dismiss="modal">Annuler</button>
                      <form method='post' action='{{route("deleteRepair",["idrepair"=>$repair->idrepair])}}'>
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-center btn-danger">Supprimer la réparation</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>


      <!-- update repair -->
      <div class="col-12 col-lg-6 justify-content-center ajustMargin" id="{{'form'.($repair->idrepair)}}" style="display:none;">
        <div class="card border-info">
          <h5 class="card-header text-info"> Mettre à Jour </h5>
          <div class="card-body">
            <form  method="post" action='{{route("updateRepair",["idrepair"=>$repair->idrepair])}}'>
              @csrf
              @method('put')

              <!-- title -->
              <div class="row">
                  <div class="col-lg-4 col-form-label card-text text-center text-info">Titre</div>
                  <div class="col-lg-8">
                      <input type="text" class="form-control" name="title" placeholder="Courroie de distribution" value="{{ $repair->title }}">
                      @if ($errors->has('title'))
                          <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('title') }} </div> </small>
                      @endif
                  </div>
              </div>

              <div class="smallMargin">
              </div>

              <!-- type -->
              <div class="row">
                  <div class="col-lg-4 col-form-label card-text text-center text-info">Type de Problème</div>
                  <div class="col-lg-8">
                    @if($repair->type =='mechanical')
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="inlineradio1" name="type" value="mechanical" checked>
                      <label class="form-check-label" for="inlineradio1">Mécanique</label>
                    </div>
                    @else
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="inlineradio1" name="type" value="mechanical">
                      <label class="form-check-label" for="inlineradio1">Mécanique</label>
                    </div>
                    @endif
                    @if($repair->type =='bodyCar')
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="inlineradio2" name="type" value="bodyCar" checked>
                      <label class="form-check-label" for="inlineradio2">Carrosserie</label>
                    </div>
                    @else
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="inlineradio2" name="type" value="bodyCar">
                      <label class="form-check-label" for="inlineradio2">Carrosserie</label>
                    </div>
                    @endif
                    @if ($errors->has('type'))
                          <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('type') }} </div> </small>
                    @endif
                  </div>
              </div>

              <div class="smallMargin">
              </div>


              <!-- description -->
              <div class="row">
                  <div class="col-lg-4 col-form-label card-text text-center text-info">Description</div>
                  <div class="col-lg-8">
                      <textarea class="form-control" id="textarea" name="description" value="{{ $repair-> description }}" rows="3"></textarea>
                      @if ($errors->has('description'))
                          <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('description') }} </div> </small>
                      @endif
                  </div>
              </div>

              <div class="smallMargin">
              </div>

              <div class="row justify-content-center">
                <div class="btn-group" role="group">
                  <button type="button" onclick="transForm('{{'show'.($repair->idrepair)}}','{{'form'.($repair->idrepair)}}')" class="btn btn-outline-warning">Annuler</button>
                  <button type="submit" class="btn btn-outline-info">Mettre à Jour</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>

    </div>
    @endforeach








  <div class="row ajustMargin">

    <div class="col-lg-3">
    </div>

    <div class="col-12 col-lg-6 justify-content-center">
      <div class="card border-info text-center">
        <a class="aInCard" href="#addCarCollapse" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="addCarCollapse">
        <h5 class="card-body text-info"> Ajouter une Réparation </h5>
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
            <form  method="POST" action="{{route('createRepair')}}">
              @csrf

              <!-- title -->
              <div class="row">
                  <div class="col-lg-4 col-form-label card-text text-center text-info">Titre</div>
                  <div class="col-lg-8">
                      <input type="text" class="form-control" name="title" placeholder="Courroie de distribution" value="{{ old('title') }}">
                      @if ($errors->has('title'))
                          <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('title') }} </div> </small>
                      @endif
                  </div>
              </div>

              <div class="smallMargin">
              </div>

              <!-- type -->
              <div class="row">
                  <div class="col-lg-4 col-form-label card-text text-center text-info">Type de Problème</div>
                  <div class="col-lg-8">
                    @if(old('type')=='mechanical')
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="inlineradio1" name="type" value="mechanical" checked>
                      <label class="form-check-label" for="inlineradio1">Mécanique</label>
                    </div>
                    @else
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="inlineradio1" name="type" value="mechanical">
                      <label class="form-check-label" for="inlineradio1">Mécanique</label>
                    </div>
                    @endif
                    @if(old('type')=='bodyCar')
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="inlineradio2" name="type" value="bodyCar" checked>
                      <label class="form-check-label" for="inlineradio2">Carrosserie</label>
                    </div>
                    @else
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="inlineradio2" name="type" value="bodyCar">
                      <label class="form-check-label" for="inlineradio2">Carrosserie</label>
                    </div>
                    @endif
                    @if ($errors->has('type'))
                          <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('type') }} </div> </small>
                    @endif
                  </div>
              </div>

              <div class="smallMargin">
              </div>


              <!-- description -->
              <div class="row">
                  <div class="col-lg-4 col-form-label card-text text-center text-info">Description</div>
                  <div class="col-lg-8">
                      <textarea class="form-control" id="textarea" name="description" value="{{ old('description') }}" rows="3"></textarea>
                      @if ($errors->has('description'))
                          <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('description') }} </div> </small>
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
