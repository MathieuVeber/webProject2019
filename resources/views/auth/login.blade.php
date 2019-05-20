@extends('layouts.navbar')

@section('head')
<title> Garage Azur VO | Connexion </title>
@endsection

@section('content')

<div id="page" class="container">

  <div class="row">

    <div class="col-lg-3">
    </div>

    <!-- Login -->

    <div class="col-12 col-lg-6 justify-content-center">
      <div class="card border-info">
        <h5 class="card-header text-info"> Connexion </h5>
        <div class="card-body">
          <form  method="post" action='{{route("attempt")}}'>
            @csrf

            <!-- email -->
            <div class="row">
                <div class="col-lg-4 col-form-label card-text text-center text-info">Email</div>
                <div class="col-lg-8">
                    <input type="email" class="form-control" name="email" placeholder="utilisateur@mail.com" value="{{old('email')}}">
                    @if ($errors->has('email'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('email') }} </div> </small>
                    @endif
                </div>
            </div>

            <div class="smallMargin">
            </div>

            <!-- password -->
            <div class="row">
                <div class="col-lg-4 col-form-label card-text text-center text-info">Mot de Passe</div>
                <div class="col-lg-8">
                    <input type="password" class="form-control" name="password" placeholder="********">
                </div>
            </div>

            <div class="smallMargin">
            </div>

            <div class="row justify-content-center">
                <button type="submit" class="btn btn-outline-info">Se Connecter</button>
            </div>

          </form>
        </div>
      </div>
    </div>


  </div>

  <div class="ajustMargin">
  </div>


@endsection
