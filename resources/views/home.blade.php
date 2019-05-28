@extends('layouts.navbar')

@section('head')
<title> Garage Azur VO | Accueil </title>
@endsection

@section('content')

<div class="container" id="page">


  <div class="row">

    <div class="col-lg-3">
    </div>

    <div class="col-12 col-lg-6 justify-content-center">
      <div class="card border-info text-center">
        <h5 class="card-body text-info" id="sellingHome"> Actualités </h5>
      </div>
    </div>

  </div>

  <div class="ajustMargin">
  </div>



  <div class="row">

    <div class="col-lg-3">
    </div>


    <!-- post -->

    <div class="col-12 col-lg-6 justify-content-center">
      <div class="card border-info">
        <h5 class="card-header text-info"> Nos nouveaux locaux ! </h5>
        <div class="card-body">
          <img class="d-block w-100" src="{{secure_asset('pictures/accueil.jpg')}}" alt="Accueil refait à neuf">



        </div>
      </div>
    </div>
  </div>


  <div class="ajustMargin">
  </div>






@if($forSale->count()>0)
<div class="row">

  <div class="col-lg-3">
  </div>

  <div class="col-12 col-lg-6 justify-content-center">
    <div class="card border-info text-center">
      <h5 class="card-body text-info" id="sellingHome"> En Vente </h5>
    </div>
  </div>

</div>

<div class="ajustMargin">
</div>
@endif

@foreach($forSale as $car)
@if($car->problem_picture != null)

<div class="row">

  <div class="col-lg-3">
  </div>


  <!-- forsale -->

  <div class="col-12 col-lg-6 justify-content-center">
    <div class="card border-info">
      <h5 class="card-header text-info"> {{$car->make}} </h5>
      <div class="card-body">
        <h5 class="card-title text-info text-center">{{$car->model}}</h5>
        <?php $res=explode('/',$car->problem_picture) ?>
        <img class="d-block w-100" src="{{$car->problem_picture}}" alt="{{$car->model}} à vendre">



      </div>
    </div>
  </div>
</div>


<div class="ajustMargin">
</div>

@endif
@endforeach


<div class="row">

  <div class="col-lg-3">
  </div>


  <!-- Contact -->

  <div class="col-12 col-lg-6 justify-content-center" id="contactHome">
    <div class="card border-info">
      <h5 class="card-header text-info"> Pour en savoir plus... </h5>
      <div class="card-body">
        <h5 class="card-title text-info text-center">Contactez-nous !</h5>

        <p class="card-text text-center text-info">Adresse email   : azvgarage@gmail.com</p>
        <p class="card-text text-center text-info">N° de Téléphone : 09 53 944 944</p>
        <p class="card-text text-center text-info">Adresse : 850, Route de Vence</p>
        <p class="card-text text-center text-info">06800 Cagnes Sur Mer</p>


      </div>
    </div>
  </div>
</div>


<div class="ajustMargin">
</div>
</div>
@endsection
