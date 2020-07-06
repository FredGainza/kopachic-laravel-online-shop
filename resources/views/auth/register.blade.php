@extends('layouts.app')

@section('content')
<div class="container">

  <div class="row">
    <div class="col s12 m10 offset-m1 l8 offset-l2">
      <div class="card">
        <form  method="POST" action="{{ route('register') }}">
          <div class="card-content">
            @csrf
            <span class="card-title">Créez votre compte</span>

            <hr>

            <x-input
              name="firstname"
              type="text"
              icon="person"
              label="Prénom"
              required="true"
            ></x-input>

            <x-input
              name="name"
              type="text"
              icon="person"
              label="Nom"
              required="true"
            ></x-input>

            <x-input
              name="email"
              type="email"
              icon="mail"
              label="Adresse mail"
              required="true"
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

            <div class="row col s12">
              <label>
                <input type="checkbox" name="newsletter" id="newsletter" {{ old('newsletter') ? 'checked' : '' }}>
                <span>Je désire recevoir votre lettre d'information</span>
              </label>
            </div>

            <div class="row col s12">
              <label>
                <input type="checkbox" name="rgpd" id="rgpd">
                <span>J'accepte les termes et conditions de <a href="#" target="_blank">la politique de confidentialité</a>.</span>
              </label>
            </div>
            
            <p>
              <button class="btn waves-effect waves-light disabled" style="width: 100%" type="submit" name="action">
                Enregistrer
              </button>
            </p>

          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const rgpd = document.querySelector('#rgpd');
    rgpd.checked = false;
    rgpd.addEventListener('change', () => document.querySelector('button[type=submit]').classList.toggle('disabled'));
  });
</script>
@endsection