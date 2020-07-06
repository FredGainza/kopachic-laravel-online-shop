@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Mettre à jour mon adresse</h2>
  <div class="row">
    <div class="card">
      <form  method="POST" action="{{ route('adresses.update', $adress->id) }}">
        @method('PUT')
        @include('account.addresses.partials.form')
      </form>
    </div>
  </div>
  <div class="row">
    <a class="waves-effect waves-light btn" href="{{ route('adresses.index') }}"> <i class="material-icons left">chevron_left</i>Retour à mes adresses</a>
  </div>
</div>
@endsection

@section('javascript')
  @include('account.addresses.partials.script')
@endsection