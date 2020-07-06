@if(isset($order) && $order->state->slug === 'annule')
  <h5>Articles de ma commande annulée</h5>
@else
  <h5>Détails de ma commande</h5>
@endif

@foreach ($content as $item)
  <hr><br>
  <div class="row">
    <div class="col m6 s12">
      {{ $item->name }} ({{ $item->quantity }} @if($item->quantity > 1) exemplaires) @else exemplaire) @endif
    </div>
    <div class="col m6 s12"><strong>{{ number_format($item->total_price_gross ?? ($tax > 0 ? $item->price : $item->price / 1.2) * $item->quantity, 2, ',', ' ') }} €</strong></div>
  </div>
@endforeach
<hr><br>

@if(isset($order) && $order->state->slug === 'annule')
  <span></span>
@else
  <div class="row" style="background-color: lightgrey">
    <div class="col s6">
      Livraison en Colissimo
    </div>
    <div class="col s6">
      <strong>{{ number_format($shipping, 2, ',', ' ') }} €</strong>
    </div>
  </div>
  @if($tax > 0)
    <div class="row" style="background-color: lightgrey">
      <div class="col s6">
        TVA à {{ $tax * 100 }}%
      </div>
      <div class="col s6">
        <strong>{{ number_format($total / (1 + $tax) * $tax, 2, ',', ' ') }} €</strong>
      </div>
    </div>
  @endif
  <div class="row" style="background-color: lightgrey">
    <div class="col s6">
      Total TTC
    </div>
    <div class="col s6">
      <strong>{{ number_format($total + $shipping, 2, ',', ' ') }} €</strong>
    </div>
  </div>
@endif