<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="{{secure_asset('css/layout.css')}}">

    <!-- Logo -->
    <link rel="icon" type="image/png" href="{{secure_asset('pictures/logo.png')}}" />

    <!-- Additional requirement -->
    @yield('head')
  </head>

  <body onload="setTimeout(fadeOut,5000)">

    <div class='jumbotron jumbotron-fluid'>
      <!-- This div contains a picture -->
    </div>

    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-info">
      <a class="navbar-brand" href="{{route('home')}}">
        <img src="{{secure_asset('pictures/logo.png')}}" width="30" height="30" class="d-inline-block align-top" alt="Logo">
        Garage Azur VO
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{route('profile',['id'=>$id])}}">Mon Espace</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('allRequests')}}">Devis & Rendez-vous</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('allRepairs')}}">Réparations</a>
          </li>
        </ul>
        <form id='formSearch' class="form-inline my-2 my-lg-0" method='get' action="">
          <input id='license_plate' class="form-control border-light text-info mr-sm-2" name='license_plate' type="search" placeholder="N° d'immatriculation" aria-label="Search">
          <button class="btn btn-outline-light my-2 my-sm-0" onclick="submitForm()">Recherche</button>
        </form>
      </div>
    </nav>

    @isset($alert)
    <div id='alert' class="text-center alert alert-{{$alert->type}} alert-block" role="alert">
      {{$alert->message}}
    </div>
    @endisset

    @yield('content')



      <!-- Footer -->
<footer class=" bg-info ">
  <div class='row'>
  <div class="smallMargin">
  </div>
</div>
  <div class="container-fluid content-align-center">

    <div class="row content-align-center">

  <div class="col text-center align-items-center text-light">
    Garage Azur VO | Réparations Tous Véhicules | Mécanique & Carrosserie | Vente Véhicules Neufs & Occasions
  </div>
  </div>
  <div class='row'>
  <div class="smallMargin">
  </div>
</div>
</div>
</footer>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{secure_asset('js/layout.js')}}"></script>
  </body>
</html>
