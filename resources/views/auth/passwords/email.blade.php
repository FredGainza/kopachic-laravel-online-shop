@extends('layouts.app')

@section('content')
<div class="container">

  @if (session('status'))
    <div class="card">
      <div class="card green darken-1">
        <div class="card-content white-text">
          {{ session('status') }}
        </div>
      </div>
    </div>
  @endif

  <div class="row">
    <div class="col s12 m10 offset-m1 l8 offset-l2">
        <div class="card">
          <form  method="POST" action="{{ route('password.email') }}">
            <div class="card-content">
              @csrf
              <span class="card-title">Renouvellement du mot de passe</span>

              <hr>

              <x-input
                name="email"
                type="email"
                icon="mail"
                label="Adresse mail"
                required="true"
                autofocus="true" 
              ></x-input>

              <p>
                <button class="btn waves-effect waves-light right" type="submit" name="action">
                  Envoyer le lien de renouvellement
                  <i class="material-icons right">lock_open</i>
                </button>
              </p>

              <br><br>

            </div>
          </form>
      </div>
    </div>
  </div>
</div>
@endsection