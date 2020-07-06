@extends('layouts.app')

@section('css')
  <style>
    .StripeElement {
      box-sizing: border-box;
      height: 40px;
      padding: 10px 12px;
      border: 1px solid transparent;
      border-radius: 4px;
      background-color: white;
      box-shadow: 0 1px 3px 0 #e6ebf1;
      -webkit-transition: box-shadow 150ms ease;
      transition: box-shadow 150ms ease;
    }
    .StripeElement--focus {
      box-shadow: 0 1px 3px 0 #cfd7df;
    }
    .StripeElement--invalid {
      border-color: #fa755a;
    }
    .StripeElement--webkit-autofill {
      background-color: #fefde5 !important;
    }
    .loader {
        margin: auto;
        border: 16px solid #e3e3e3;
        border-radius: 50%;
        border-top: 16px solid #1565c0;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
  </style>
@endsection

@section('content')
<div class="container">
  <h2>Détails de ma commande</h2>
  <div class="row">
    <div class="col s12">
      <div class="card">
        <div class="card-content">
          <p><strong>Commande n° {{ $order->reference }}</strong></p>
          @if($order->purchase_order)
            <p><strong>Bon de commande n° {{ $order->purchase_order }}</strong></p>
          @endif
          <p><strong>Date :</strong> {{ $order->created_at->calendar() }}</p>
        </div>
      </div>
    </div>
    <div class="col s12">
      <div class="card">
        <div class="card-content">
          @include('command.partials.detail', [
            'content' => $order->products,
            'shipping' => $order->shipping,
            'tax' => $order->tax,
            'total' => $order->total,
          ]) 
        </div>
      </div>
    </div>
    <div class="col s12">
      <div class="card">
        <div class="card-content">
          <p><strong>Moyen de paiement :</strong> {{ $order->payment_text }}</p>
          <p><strong>Etat : </strong>{{ $order->state->name }}</p>
          @if($order->state->slug === 'carte' || $order->state->slug === 'erreur')
            @include('command.partials.stripe')
          @endif
          @if($order->invoice_id)
            <br>
            <td><a href="{{ route('invoice', $order->id) }}" class="waves-effect waves-light btn-small">Télécharger la facture</a></td>
          @endif
        </div>
      </div>
    </div>
    <div class="col s12">
      <div id="payment-ok" class="card center-align white-text green darken-4 hide">
        <div class="card-content">
          <span class="card-title">Votre paiement a été validé</span>
          @if($order->pick)
            <p>Vous pouvez venir chercher votre commande</p>
          @else
            <p>Votre commande va vous être envoyée</p>
          @endif
        </div>
      </div>
    </div> 
    <div class="col s12">
      <div class="card">
        <div class="card-content">
          <span class="card-title">Adresse de facturation @if($order->adresses->count() === 1) et de livraison @endif</span>
          @include('account.addresses.partials.address', ['address' => $order->adresses->first()])
        </div>
      </div>
    </div>
    @if($order->adresses->count() === 2)
      <div class="col s12">
        <div class="card">
          <div class="card-content">
            <span class="card-title">Adresse de livraison</span>
            @include('account.addresses.partials.address', ['address' => $order->adresses->get(1)])
          </div>
        </div>
      </div>
    @endif
    @if($order->pick)
      <div class="col s12">
        <div class="card">
          <div class="card-content">
            <p>J'ai choisi de venir chercher ma commande sur place.</p>
          </div>
        </div>
      </div>
    @endif
  </div>
  <div class="row">
    <a class="waves-effect waves-light btn" href="{{ route('commandes.index') }}"> <i class="material-icons left">chevron_left</i>Retour à mes commandes</a>      
  </div>  
</div>
@endsection

@section('javascript')
  @include('command.partials.stripejs')
@endsection