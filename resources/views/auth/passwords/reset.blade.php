@extends('layouts.app')

@section('content')
<div class="container">

  <div class="row">
    <div class="col s12 m10 offset-m1 l8 offset-l2">
        <div class="card">
          <form  method="POST" action="{{ route('password.update') }}">
            <div class="card-content">
              @csrf
              <input type="hidden" name="token" value="{{ $token }}">

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

              <x-input
                name="password"
                type="password"
                icon="lock"
                label="Mot de passe"
                required="true"
              ></x-input>

              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">lock</i>
                  <input id="password-confirm" type="password" name="password_confirmation" required>
                  <label for="password-confirm">Confirmation du mot de passe</label>
                </div>
              </div>

              <p>
                <button class="btn waves-effect waves-light" type="submit" name="action">Renouveler !
                  <i class="material-icons right">lock_open</i>
                </button>
              </p>

            </div>
          </form>
      </div>
    </div>
  </div>
</div>
@endsection