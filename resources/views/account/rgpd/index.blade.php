@extends('layouts.app')

@section('content')
<div class="container">
  <h2 class="titre">RGPD</h2>
  <div class="row">
    <div class="card">
      <div class="card-content">
        <ul class="collapsible">
          <li>
            <div class="collapsible-header"><i class="material-icons">info</i>Accès à mes informations</div>
            <div class="collapsible-body informations">
              <ul>
                <li class="center-align">{{ config('messages.rgpd') }}</li>
                <br>
              <li><a href="{{ route('identite.pdf') }}" class="waves-effect waves-light btn" style="width: 100%">Récupérer mes informations</a></li>
              </ul>
            </div>
          </li>
          <li>
            <div class="collapsible-header"><i class="material-icons">edit</i>Rectification des erreurs</div>
            <div class="collapsible-body informations">
              <ul>
              <li class="center-align">Vous pouvez modifier toutes les informations personnelles accessibles depuis la page de votre compte : identité, adresses. Pour toute autre rectification contactez nous en nous envoyant un e-mail à cette adresse : {{ $email }}. Nous vous répondrons dans les plus brefs délais.</li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="row">
    <a class="waves-effect waves-light btn" href="{{ route('account') }}"> <i class="material-icons left">chevron_left</i>Retour à mon compte</a>
  </div>
</div>
@endsection