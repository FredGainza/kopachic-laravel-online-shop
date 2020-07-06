@extends('layouts.app')

@section('css')
  <style>
    .card {
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

    .card--focus {
      box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .card--invalid {
      border-color: #fa755a;
    }

    .card--webkit-autofill {
      background-color: #fefde5 !important;
    }

    .link-perso {
        color: #fa5221;
        text-decoration: none;
    }
    .link-perso:hover {
        color: #fc8a69;
        text-decoration: underline;
    }
  </style>
@endsection

@section('content')
<div class="container">
    <ul class="collection with-header">
        <li class="collection-item">
            {{-- {{dd($order->state->slug)}} --}}
            @if($order->state->slug === 'paiement_ok')
                <div id="payment-ok" class="center-align white-text green darken-4">
                    <div class="card-content p-t-0-5 p-b-1">
                        <h5 class="card-title m-b-0-5">Votre paiement a été validé</h5>
                        @if((session('transacId') !== null))
                            <h6 class="m-y-0 p-y-0">(Transaction Id : <strong>{{ session('transacId') }}</strong>)</h6><br>
                        @endif
                            @if($order->pick)
                                <span>Vous pouvez venir chercher votre commande</span>
                            @else
                                <span>Votre commande va vous être envoyée</span>
                            @endif  
                        <p>Vous pouvez télécharger votre facture en cliquant <a class="link-perso" href="{{ route('invoice', $order->id) }}">ici</a></p>
                    </div>
                </div>
            @endif
            @if($order->state->slug === 'annule')
              <div id="payment-ok" class="center-align white-text red darken-4">
                <div class="card-content p-t-0-5 p-b-1">
                    <h5 class="card-title">Votre paiement a été annulé, aucun prélèvement n'a été effectué sur votre compte</h5>
                    <p>Merci de recommencer le processus de commande si vous désirez toujours acheter les produits annulés.</p>
                    <p>Pour info, vous trouverez ces produits ci-dessous.</p>
                </div>
              </div>
            @endif
        </li>
    </ul>

  <ul class="collection">

    <li id="detail" class="collection-item">
      @include('command.partials.detail', [
        'tax' => $order->tax,
        'shipping' => $order->shipping,
        'total' => $order->total,
        'content' => $order->products,
      ])

      @if(isset($order) && $order->state->slug !== 'annule')
        <div class="row">
          <div class="col s6">
            Référence de la commande :
          </div>
          <div class="col s6">
            <strong>{{ $order->reference }}</strong>
          </div>
        </div>
        <div class="row">
          <div class="col s6">
            Moyen de paiement :
          </div>
          <div class="col s6">
            <strong>{{ $order->payment_text }}</strong>
          </div>
        </div> 

      @elseif(isset($order) && $order->state->slug === 'annule')
        <div class="row center-align">
          <h5><strong class="red-text">Commande {{ $order->reference }} annulée.</strong></h5>
        </div>
      @endif
    </li> 

    <li class="collection-item">      
      <div class="row">
        <div class="grid-example col s12 m6">
          <h5>Adresse de facturation @if($order->adresses->count() === 1) et de livraison @endif</h5>
          @include('account.addresses.partials.address', [
            'address' => $order->adresses->first(),
          ])
        </div>
        @if($order->adresses->count() > 1)
          <div class="grid-example col s12 m6">
            <h5>Adresse de livraison</h5>
            @include('account.addresses.partials.address', [
              'address' => $order->adresses->last(),
            ])
          </div>
        @endif
      </div>
    </li>

  </ul>

    <ul class="collection with-header">
        <li class="collection-item">
            <p>Pour toute question ou information complémentaire merci de contacter notre support client.</p>
        </li>
    </ul>

</div>
@endsection