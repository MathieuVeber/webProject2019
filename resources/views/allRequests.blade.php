
@extends('layouts.navbar')

@section('head')
<title> Garage Azur VO | Devis & Rendez-vous </title>
@endsection

@section('content')

<div class="container" id="page">


<div class="row">

  <div class="col-lg-3">
  </div>

  <div class="col-12 col-lg-6 justify-content-center">
    <div class="card border-info text-center">
      <h5 class="card-body text-info"> Demande de Devis et de Rendez-vous </h5>
    </div>
  </div>

</div>

<div class="ajustMargin">
</div>

@foreach($cars as $car)
<div class="row">

  <div class="col-lg-3">
  </div>


      <div class="col-12 col-md-6 ajustMargin">
      <div class="card bg-info">
          <h5 class="card-header text-white text-center">{{$car->license_plate}}</h5>
          <div class="card-body">
            <p class="card-text text-center text-white">Problème : {{$car->problem_type}}</p>
            <p class="card-text text-center text-white">Description : {{$car->problem_description}}</p>
            <p class="card-text text-center text-white">Propriétaire : {{$car->email}}</p>
            <p class="card-text text-center text-white">Contact : 0{{$car->phone}}</p>

            <div class="row justify-content-center">
              <div class="btn-group" role="group">
                <a class="btn-default btn btn-outline-light text-light" href="{{route('adminCar', ['id'=>$id, 'license_plate'=>$car->license_plate])}}" role="button">Infos Véhicule</a>
                <button type="button" class="btn btn-light text-info" data-toggle="modal" data-target="#pictureModal">Photo</button>
              </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="pictureModal" tabindex="-1" role="dialog" aria-labelledby="pictureTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="pictureTitle">{{$car->updated_at}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="col-8">
                      <?php $res=explode('/',$car->problem_picture) ?>
                      <img class="img-fluid" src="{{secure_asset('/pictures/'.$res[1])}}" alt="Photo du choc">
                      {{-- TO NOT forget to change for Amazon S3 in the future --}}
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
    </div>
    @endforeach


    <div class="row">

      <div class="col-5">
      </div>

      <div class="col-2">
        <div class="row justify-content-center">
          {{ $cars->links() }}
        </div>
      </div>

    </div>

</div>

@endsection
