
@extends('layouts.navbar')

@section('head')
<title> Garage Azur VO | Recherche {{$license_plate}} </title>
@endsection

@section('content')

<div class="container" id="page">

<div class="ajustMargin">
</div>

<div class="row">

  <div class="col-lg-3">
  </div>

  <div class="col-12 col-lg-6 justify-content-center">
    <div class="card bg-info text-center">
      <h5 class="card-body text-white"> Résultats pour {{$license_plate}} </h5>
    </div>
  </div>

</div>

<div class="ajustMargin">
</div>

<div class="row">

  <div class="col justify-content-center">
    <div class="card-deck">

      @foreach($cars as $car)
      <div class="col-12 col-md-6 col-lg-4 ajustMargin">
      <div class="card bg-info">
        <a href="{{route('adminCar', ['id'=>$id, 'license_plate'=>$car->license_plate])}}" class="aInCard">
          <h5 class="card-header text-white text-center">{{$car->license_plate}}</h5>
          <div class="card-body">
            <p class="card-text text-center text-white">Modèle : {{$car->model}}</p>
            <p class="card-text text-center text-white">Marque : {{$car->make}}</p>
            <p class="card-text text-center text-white">Année de sortie : {{$car->year}}</p>
            <p class="card-text text-center text-white">Mise en circulation : {{$car->firstRegistration}}</p>

          </div>
        </a>
      </div>
    </div>

      @endforeach
    </div>
  </div>

</div>

<div class="row">

  <div class="col-md-4">
  </div>

  <div class="col-12 col-md-4">
    <div class="row justify-content-center">
      {{ $cars->links() }}
    </div>
  </div>

</div>

</div>
@endsection
