@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Nouvelle adresse</h2>
  @if(session()->has('message'))
    <h5 class="center-align blue-text">{{ session('message') }}</h5>
    <br>
  @endif
  <div class="row">
    <div class="card" id="account">
      <form  method="POST" action="{{ route('adresses.store') }}">
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