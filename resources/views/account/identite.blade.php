@extends('layouts.app')

@section('content')
<div class="container">
  <h2 class="center-align">Mes informations personnelles</h2>
  <div class="row">
    <div class="col s12 m10 offset-m1 l8 offset-l2">
      <div class="card">
        <form  method="POST" action="{{ route('identite.update') }}">
          @csrf
          @method('PUT')
          @if(session()->has('message'))
            <div class="col s12">
              <div class="card teal darken-1">
                <div class="card-content white-text center-align">
                  {{ session('message') }}
                </div>
              </div>
            </div>
          @endif
          <div class="card-content">
            
            <x-input
              name="firstname"
              type="text"
              icon="person"
              label="Prénom"
              required="true"
              :value="$user->firstname"
            ></x-input>
            <x-input
              name="name"
              type="text"
              icon="person"
              label="Nom"
              required="true"
              :value="$user->name"
            ></x-input>
            <x-input
              name="email"
              type="email"
              icon="mail"
              label="Adresse mail"
              required="true"
              :value="$user->email"
            ></x-input>
            <div class="row col s12">
              <label>
                <input type="checkbox" name="newsletter" id="newsletter" {{ old('newsletter', $user->newsletter) ? 'checked' : '' }}>
                <span>{{ config('messages.newsletter') }}</span>
              </label>
            </div>
            <div class="row col s12">
              <label>
                <input type="checkbox" name="rgpd" id="rgpd" {{ old('rgpd') ? 'checked' : '' }}>
                <span>{{ config('messages.accept') }}</span>
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
  <div class="row">
    <a class="waves-effect waves-light btn" href="{{ route('account') }}"> <i class="material-icons left">chevron_left</i>Retour à mon compte</a>
  </div>
</div>
@endsection

@section('javascript')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const rgpd = document.querySelector('#rgpd');
      rgpd.checked = false;
      rgpd.addEventListener('click', () => document.querySelector('button[type=submit]').classList.toggle('disabled'));
    });
  </script>
@endsection