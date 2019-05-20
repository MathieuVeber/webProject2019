@extends('layouts.navbar')

@section('head')
<title> Garage Azur VO | Inscription </title>
@endsection

@section('content')

<div id="page" class="container">

  <div class="row">

    <div class="col-lg-3">
    </div>

    <!-- register -->

    <div class="col-12 col-lg-6 justify-content-center">
      <div class="card border-info">
        <h5 class="card-header text-info"> Inscription </h5>
        <div class="card-body">
          <form  method="post" action='{{route("createUser")}}'>
            @csrf

            <!-- email -->
            <div class="row">
              <div class="col-lg-4 col-form-label card-text text-center text-info">Email</div>
                <div class="col-lg-8">
                    <input type="email" class="form-control" name="email" placeholder="utilisateur@mail.com">
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
                    @if ($errors->has('password'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('password') }} </div> </small>
                    @endif
                </div>
            </div>

            <div class="smallMargin">
            </div>

            <!-- password_confirmation -->
            <div class="row">
                <div class="col-lg-4 col-form-label card-text text-center text-info">Confirmation</div>
                <div class="col-lg-8">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="********">
                </div>
            </div>

            <div class="smallMargin">
            </div>

            <!-- gender -->
            <div class="row">
              <div class="col-lg-4 col-form-label card-text text-center text-info">Civilité</div>
                <div class="col-lg-8">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="F">
                    <label class="form-check-label" for="inlineRadio1">Mme</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="M">
                    <label class="form-check-label" for="inlineRadio2">M</label>
                  </div>
                    @if ($errors->has('gender'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('gender') }} </div> </small>
                    @endif
                </div>
            </div>

            <div class="smallMargin">
            </div>

            <!-- lastName -->
            <div class="row">
              <div class="col-lg-4 col-form-label card-text text-center text-info">Nom</div>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="lastName" placeholder="Dupont">
                    @if ($errors->has('lastName'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('lastName') }} </div> </small>
                    @endif
                </div>
            </div>

            <div class="smallMargin">
            </div>

            <!-- firstName -->
            <div class="row">
              <div class="col-lg-4 col-form-label card-text text-center text-info">Prénom</div>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="firstName" placeholder="Jean">
                    @if ($errors->has('firstName'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('firstName') }} </div> </small>
                    @endif
                </div>
            </div>

            <div class="smallMargin">
            </div>

            <!-- phone -->
            <div class="row">
              <div class="col-lg-4 col-form-label card-text text-center text-info">Téléphone</div>
                <div class="col-lg-8">
                    <input type="number" class="form-control" name="phone" placeholder="06 66 66 66 42">
                    @if ($errors->has('phone'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('phone') }} </div> </small>
                    @endif
                </div>
            </div>

            <div class="smallMargin">
            </div>

            <!-- zipCode -->
            <div class="row">
              <div class="col-lg-4 col-form-label card-text text-center text-info">Code Postal</div>
                <div class="col-lg-8">
                    <input type="number" class="form-control" name="zipCode" placeholder="34000">
                    @if ($errors->has('zipCode'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('zipCode') }} </div> </small>
                    @endif
                </div>
            </div>

            <div class="smallMargin">
            </div>


            <div class="row justify-content-center">
                <button type="submit" class="btn btn-outline-info">S'inscrire</button>
            </div>

          </form>
        </div>
      </div>
    </div>


  </div>

  <div class="ajustMargin">
  </div>


@endsection
