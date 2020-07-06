
@extends('back.layout')
@section('main') 
  <div class="card">
    <h5 class="card-header">Identité</h5>
    <div class="card-body">
      <dl class="row">
        <dt class="col-sm-3">Nom</dt>
        <dd class="col-sm-9">{{ $user->name }}</dd>      
        <dt class="col-sm-3">Prénom</dt>
        <dd class="col-sm-9">{{ $user->firstname }}</dd>      
        <dt class="col-sm-3">Email</dt>
        <dd class="col-sm-9"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></dd>      
        <dt class="col-sm-3 text-truncate">Date d'inscription</dt>
        <dd class="col-sm-9">{{ $user->created_at->format('d/m/Y') }}</dd>
        <dt class="col-sm-3 text-truncate">Dernière mise à jour</dt>
        <dd class="col-sm-9">{{ $user->updated_at->format('d/m/Y') }}</dd>        
        <dt class="col-sm-3">Lettre d'information</dt>
        <dd class="col-sm-9">@if($user->newsletter) Oui @else Non @endif</dd>
      </dl>
    </div>
  </div>
  @if($user->orders->isNotEmpty())
    <div class="card">
      <h5 class="card-header">Commandes</h5>
      <div class="card-body">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Référence</th>
              <th>Date</th>
              <th>Prix total</th>
              <th>Paiement</th>
              <th>État</th>
              <th></th>
            </tr>
          </thead>    
          <tbody>
              @foreach($user->orders as $order)
              <tr>
                <td>{{ $order->reference }}</td>
                <td>{{ $order->created_at->calendar() }}</td>
                <td>{{ $order->total }} €</td>
                <td>{{ $order->payment_text }}</td>
                <td><span class="badge badge-{{ config('colors.' . $order->state->color) }}">{{ $order->state->name }}</span></td>
                <td style="text-align: center"><a href="{{ route('orders.show', $order->id) }}" class="btn btn-dark btn-sm">Voir</a></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  @endif
  <div class="card">
    <h5 class="card-header">@if($user->addresses->count() === 1) Adresse @else Adresses @endif</h5>
    <div class="card-body">
      <div class="row">
        @foreach($user->addresses as $address)
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card">
              <div class="card-body">
                @include('account.addresses.partials.address')
              </div>
            </div>
          </div>
        @endforeach
      </div>    
    </div>
  </div>
  <div class="form-group row mb-0">
    <div class="col-md-12">
      <a class="btn btn-dark" href="{{ route('clients.index') }}" role="button"><i class="fas fa-arrow-left"></i> Retour à la liste des clients</a>    
    </div>
  </div><br>
@endsection