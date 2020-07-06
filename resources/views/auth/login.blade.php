@extends('layouts.app')

@section('content')
<div class="container">

  <div class="row">
    <div class="col s12 m10 offset-m1 l8 offset-l2">
      <div class="card">
        <form  method="POST" action="{{ route('login') }}">
          @if(url()->previous() === route('panier.index'))
            <div class="col s12">
              <div class="card deep-orange lighten-1">
                <div class="card-content white-text center-align">
                  Vous devez être connecté pour passer une commande, si vous n'avez pas encore de compte vous pouvez en créer un en utilisant le lien sous ce formulaire.
                </div>
              </div>
            </div>
          @endif
          <div class="card-content">
            @csrf
            <span class="card-title">Connexion</span>

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

            <div class="row col s12">
              <label>
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <span>Se rappeler de moi</span>
              </label>
            </div>

            <p>
              <button class="btn waves-effect waves-light" style="width:100%" type="submit" name="action">Connexion
                <i class="material-icons right">lock_open</i>
              </button>
            </p>

            <br>

          </div>

          <div class="card-action">
            <p><a href="{{ route('password.request') }}">Mot de passe oublié ?</a></p>
            <p><a href="{{ route('register') }}">Pas de compte ? Créez-en un</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection