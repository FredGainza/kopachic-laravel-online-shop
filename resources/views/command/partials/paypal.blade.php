<br>
{{-- <div id="payment-pending" class="card">
  <div class="card-content center-align">
    <span class="card-title">Vous avez choisi de payer avec Paypal.</span>
    <p class="orange-text">Veuillez cliquer sur le bouton ci-dessous pour procéder au règlement.</p>
    <p class="orange-text">La transmission des informations entre notre site et celui de paypal est entièrement sécurisée.</p>
    <br>
    <div class="row">
        <div id="paypal-button-container"></div>
    </div>
  </div>
</div> --}}
@if($order->state->slug === 'paypal')
<div id="payment-pending" class="paypal">
  <div class="card-content center-align">
    <span class="card-title">Vous avez choisi de payer avec Paypal.</span>
    <p class="green-text">Veuillez cliquer sur le bouton ci-dessous pour procéder au règlement.<br>
    La transmission des informations entre notre site et celui de paypal est entièrement sécurisée.</p>
    {{-- <div class="row"> --}}
      <div class="gateway--paypal">
        @if(session()->has('message'))
          <p class="message">
              {{ session('message') }}
          </p>
        @endif
        <form id="payment-form" method="POST" action="{{ route('checkout.payment.paypal', ['order' => $order->id]) }}">
            {{ csrf_field() }}
            <div id="card-errors" class="helper-text red-text"></div>
            {{-- <br> --}}
            <div id="wait" class="hide">
              <div class="loader"></div>
              {{-- <br> --}}
              <p><span class="red-text card-title center-align">Processus de paiement en cours, ne fermez pas cette fenêtre avant la fin du traitement !</span></p>
            </div>
            {{-- <button class="btn btn-pay">
                <i class="fa fa-paypal" aria-hidden="true"></i> Pay with PayPal
            </button> --}}
            <button class="paypal-button">
              <span class="paypal-button-title">
                Payer avec
              </span>
              <span class="paypal-logo">
                <i>Pay</i><i>Pal</i>
              </span>
            </button>
        </form>
        <br>
    </div>
    {{-- </div> --}}
  </div>
</div>
@endif