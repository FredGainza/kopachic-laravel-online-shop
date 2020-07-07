@extends('back.layout')
@section('main') 
  <div class="card">
    <h5 class="card-header d-flex">Commande 
        <span class="badge badge-info mx-3">{{ $order->reference }}</span> 
        <span class="badge badge-info mx-3">N° {{ $order->id }}</span>
        @if ($order->updated_at > $order->created_at) 
            <span class="text-danger mx-3">
                Modifiée le {{ $order->updated_at->format('d/m/Y') }} 
            </span>
            <span class="text-danger ml-auto fz-90">
                Créée le {{ $order->created_at->format('d/m/Y') }}
            </span>
        @else 
            <span class="text-danger mx-3">
                Créée le {{ $order->created_at->format('d/m/Y') }} 
            </span>
        @endif
    </h5>
    <div class="card-body">
      <div class="card">
        <h5 class="card-header">Mode de paiement</span></h5>
        <div class="card-body">
          <p>{{ $order->payment_text }}</p>
          @if($order->payment_infos)
            ID de paiement : <span class="badge badge-secondary">{{ $order->payment_infos->payment_id }}</span>
          @endif
        </div>
      </div>
      @if($shop->invoice && ($order->invoice_id || $order->state->indice > $annule_indice))
        <div class="card">        
          <h5 class="card-header">Facture</h5>
          <div class="card-body">  
            @if(session('invoice'))
              <div class="alert alert-danger" role="alert">
                  {{ session('invoice') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
            @endif
            @if($order->invoice_id)
              <p>La facture a été générée avec l'id <strong>{{ $order->invoice_id }}</strong> et le numéro <strong>{{ $order->invoice_number }}</strong>.</p>
            @else
              <form method="POST" action="{{ route('orders.invoice', $order->id) }}">
                @csrf
                <x-checkbox
                  name="paid"
                  label="Le paiement a été effectué"
                  :value="$order->state->indice > 3"
                ></x-checkbox>
                <button type="submit" class="btn btn-dark">Générer la facture</button>
              </form>
            @endif
          </div>
        </div>
      @endif
      @if($order->payment === 'mandat')
        <div class="card">
          <h5 class="card-header">Bon de commande</h5>
          <div class="card-body">
            <form method="POST" action="{{ route('orders.updateNumber', $order->id) }}">
              @method('PUT')
              @csrf   
              <x-inputbs4
                name="purchase_order"
                type="text"
                label="N° du bon de commande"
                :value="$order->purchase_order"
              ></x-inputbs4>
              <button type="submit" class="btn btn-dark"  @if($order->state->indice >= 3) disabled @endif>Mettre à jour le numéro du bon de commande</button>
            </form>
          </div>
        </div>
      @endif
      <div class="card">
        <h5 class="card-header">Etat : <span class="badge badge-{{ config('colors.' . $order->state->color) }}"> {{ $order->state->name }}</span></h5>
        <div class="card-body">
          <form method="POST" action="{{ route('orders.update', $order->id) }}">
            @method('PUT')
            @csrf   
            <select id="state_id" name="state_id" class="custom-select custom-select-md mb-3">
              @foreach($states as $state)
                <option data-slug="{{ $state->slug }}" value="{{ $state->id }}" @if($order->state->id === $state->id) selected @endif>{{ $state->name }}</option>
              @endforeach
            </select>
            <button type="submit" class="btn btn-dark">Mettre à jour l'état</button>
          </form>
        </div>
      </div>
      <div class="card">
        <h5 class="card-header">Produits</h5>
        <div class="card-body">
          @foreach ($order->products as $item)
            <br>
            <div class="row">
              <div class="col m6 s12">
                {{ $item->name }} ({{ $item->quantity }} @if($item->quantity > 1) exemplaires) @else exemplaire) @endif
              </div>
              <div class="col m6 s12"><strong>{{ number_format($item->total_price_gross, 2, ',', ' ') }} €</strong></div>
            </div>
          @endforeach
          <hr><br>
          <div class="row" style="background-color: lightgrey">
            <div class="col s6">
              Total HT
            </div>
            <div class="col s6">
              <strong>{{ number_format($order->ht, 2, ',', ' ') }} €</strong>
            </div>
          </div>
          <br>
          <div class="row" style="background-color: lightgrey">
            <div class="col s6">
              Livraison en Colissimo
            </div>
            <div class="col s6">
              <strong>{{ number_format($order->shipping, 2, ',', ' ') }} €</strong>
            </div>
          </div>
          <br>
          @if($order->tax > 0)
            <div class="row" style="background-color: lightgrey">
              <div class="col s6">
                TVA à {{ $order->tax * 100 }} %
              </div>
              <div class="col s6">
                <strong>{{ number_format($order->tva, 2, ',', ' ') }} €</strong>
              </div>
            </div>
            <br>
          @endif
          <div class="row" style="background-color: lightgrey">
            <div class="col s6">
              Total TTC
            </div>
            <div class="col s6">
              <strong>{{ number_format($order->totalOrder, 2, ',', ' ') }} €</strong>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <h5 class="card-header">Livraison</h5>
        <div class="card-body">
          @if($order->pick)
            Le client a choisi de venir chercher sa commande sur place
          @else
            Livraison normale en Colissimo
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <h5 class="card-header">Client : 
    <a href="{{ route('clients.show', $order->user->id) }}"><span class="badge badge-primary">{{ $order->user->firstname . ' ' . $order->user->name }}</span></a>  
      <span class="badge badge-secondary">N° {{ $order->user->id }}</span>
    </h5>
    <div class="card-body">
      <div class="card">
        <div class="card-body">
          <dl class="row">  
            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9"><a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a></dd>      
            <dt class="col-sm-3 text-truncate">Date d'inscription</dt>
            <dd class="col-sm-9">{{ $order->user->created_at->format('d/m/Y') }}</dd>
            <dt class="col-sm-3 text-truncate">Commandes validées</dt>
            <dd class="col-sm-9"><span class="badge badge-primary">{{ $order->user->orders->where('state_id', '>', 5)->count() }}</span></dd>
          </dl>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <h5 class="card-header">Adresses</h5>
    <div class="card-body">
      <div class="card">
        <div class="card-body">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><i class="fas fa-truck mr-2"></i> Adresse d'expédition</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><i class="fas fa-euro-sign mr-2"></i> Adresse de facturation</a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"><br>
              @if($order->adresses->count() === 1)
                @include('account.addresses.partials.address', ['address' => $order->adresses->first()])
              @else
                @include('account.addresses.partials.address', ['address' => $order->adresses->get(1)])
              @endif
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"><br>
              @include('account.addresses.partials.address', ['address' => $order->adresses->first()])
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection