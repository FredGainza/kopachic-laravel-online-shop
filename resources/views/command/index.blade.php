@extends('layouts.app')

@section('content')
<div class="container">
  <form id="form" action="{{ route('commandes.store') }}" method="POST">
    @csrf      
    @if(session()->has('message'))
      <h5 class="center-align red-text">{{ session('message') }}</h5>
      <br>
    @endif
    <ul class="collection with-header">
      <li class="collection-header"><h4>Ma commande</h4></li>
      <div id="wrapper">
      <li class="collection-item">
        <h5>Adresse de facturation <span id="solo">et de livraison</span></h5>
        @include('command.partials.addresses', ['name' => 'facturation'])
        <div class="row">
          <div class="col s12">
            <a href="{{route('adresses.index')}}" class="btn" style="width: 100%"><i class="material-icons left">location_on</i>Gérer mes Adresses</a>
          </div>
        </div>
        <div class="row">
          <div class="col s12">
            <label>
              <input id="different" name="different" type="checkbox" @if($addresses->count() === 1)  disabled="disabled" @endif>
              <span>
                @if($addresses->count() === 1)
                  Vous n'avez qu'une adresse enregistrée, si vous voulez une adresse différente pour la livraison <a href="{{ route('adresses.create') }}">vous pouvez en créer une autre</a>.
                @else
                  Mon adresse de livraison est différente de mon adresse de facturation
                @endif
              </span>
            </label>
          </div>
        </div>
      </li>
      <li id="liLivraison" class="collection-item hide">
        <h5>Adresse de livraison</h5>
        @include('command.partials.addresses', ['name' => 'livraison'])      
      </li>
      <li class="collection-item">
        <h5>Mode de livraison</h5>
        <p>
          <label>
            <input name="expedition" type="radio" value="colissimo" checked>
            <span>Colissimo</span>
          </label>
        </p>
        <p>
          <label>
            <input name="expedition" type="radio" value="retrait">
            <span>Retrait sur place</span>
          </label>
        </p>
      </li>
      <li class="collection-item">
        <h5>Paiement</h5>
        @if($shop->card)
          <p>
            <label>
              <input class="payment" name="payment" type="radio" value="carte" checked>
              <span>Carte bancaire</span>
            </label>
          </p>
          <p style="margin-left: 40px" class="hide">
            Vous devrez renseigner un formulaire de paiement sur la page de confirmation de cette commande.
          </p>
        @endif
        @if($shop->paypal)
          <p>
            <label>
              <input class="payment" name="payment" type="radio" value="paypal">
              <span>Paiement Paypal</span>
            </label>
          </p>
          <p style="margin-left: 40px" class="hide">
            Vous serez redirigé vers la plateforme Paypal pour effectuer le paiement.
          </p>
        @endif
        @if($shop->mandat)
          <p>
            <label>
              <input class="payment" name="payment" type="radio" value="mandat">
              <span>Mandat administratif</span>
            </label>
          </p>
          <p style="margin-left: 40px" class="hide">
            Envoyez un bon de commande avec la mention "Bon pour accord". Votre commande sera expédiée dès réception de ce bon de commande. N'oubliez pas de préciser la référence de la commande dans votre bon.
          </p>
        @endif
        @if($shop->transfer)         
          <p>
            <label>
              <input class="payment" name="payment" type="radio" value="virement">
              <span>Virement bancaire</span>
            </label>
          </p>
          <p style="margin-left: 40px" class="hide">
            Il vous faudra transférer le montant de la commande sur notre compte bancaire. Vous recevrez votre confirmation de commande comprenant nos coordonnées bancaires et le numéro de commande. Les biens seront mis de côté 30 jours pour vous et nous traiterons votre commande dès la réception du paiement. 
          </p>
        @endif
        @if($shop->check)
          <p>
            <label>
              <input class="payment" name="payment" type="radio" value="cheque">
              <span>Chèque</span>
            </label>
          </p>
          <p style="margin-left: 40px" class="hide">
            Il vous faudra nous envoyer un chèque du montant de la commande. Vous recevrez votre confirmation de commande comprenant nos coordonnées bancaires et le numéro de commande. Les biens seront mis de côté 30 jours pour vous et nous traiterons votre commande dès la réception du paiement. 
          </p>
        @endif
      </li>
      <li id="detail" class="collection-item">
        @include('command.partials.detail')      
      </li> 
        
      <li class="collection-item">
        <h5>Veuillez vérifier votre commande avant le paiement !</h5>
        <br>
        <div class="row">
          <div class="col s12">
            <label>
              <input id="ok" name="ok" type="checkbox">
              <span>J'ai lu <a href="#" target="_blank">les conditions générales de vente et les conditions d'annulation</a> et j'y adhère sans réserve. </span>
            </label>
          </div>
        </div>
      </li>
      </div>
      <div id="loader" class="hide">
        <div class="loader"></div>
      </div>
    </ul>
    <div class="row">
      <div class="col s12">
        <button id="commande" type="submit" class="btn disabled" style="width: 100%">Commande avec obligation de paiement</button>
      </div>
    </div>
  </form>
</div>
@endsection
@section('javascript')
  <script>
    const changePayment = () => {
      document.querySelectorAll('.payment').forEach(payment => {
        const list = payment.parentNode.parentNode.nextElementSibling.classList;
        if(payment.checked) {
          list.remove('hide');
        } else {
          list.add('hide');
        } 
      });      
    };
    const getDetails = async () => {
      document.querySelector('#wrapper').classList.add('hide');
      document.querySelector('#loader').classList.remove('hide');
      const response = await fetch('{{ route("commandes.details") }}', { 
        method: 'POST',
        headers: { 
          'X-CSRF-TOKEN': '{{ csrf_token() }}', 
          'Content-Type': 'application/json' 
        },
        body: JSON.stringify({ 
          facturation: document.querySelector('input[type=radio][name=facturation]:checked').value, 
          livraison: document.querySelector('input[type=radio][name=livraison]:checked').value,
          different: document.querySelector('#different').checked,
          pick: document.querySelector('input[type=radio][name=expedition]:checked').value == 'retrait'
        })
      });
      const data = await response.json();
      document.querySelector('#detail').innerHTML = data.view;
      document.querySelector('#loader').classList.add('hide');
      document.querySelector('#wrapper').classList.remove('hide');      
    };
    document.addEventListener('DOMContentLoaded', () => {
      
      document.querySelector('#different').checked = false;
      
      document.querySelector('#ok').checked = false;
      
      document.querySelector('#different').addEventListener('change', () => {
        document.querySelector('#liLivraison').classList.toggle('hide');
        document.querySelector('#solo').classList.toggle('hide');
        getDetails();
      });
      document.querySelectorAll('.payment').forEach(payment => {
        payment.addEventListener('change', () => changePayment());
      });
      
      document.querySelector('#ok').addEventListener('change', () => document.querySelector('#commande').classList.toggle('disabled'));
      
      document.querySelectorAll('input[type=radio][name=facturation]').forEach(input => {
        input.addEventListener('change', () => getDetails());
      });
      document.querySelectorAll('input[type=radio][name=livraison]').forEach(input => {
        input.addEventListener('change', () => getDetails());
      });
      document.querySelectorAll('input[type=radio][name=expedition]').forEach(input => {
        input.addEventListener('change', () => {
          if(document.querySelector('input[type=radio][name=expedition][value=retrait]').checked) {            
            if(document.querySelector('#different').checked) {
              document.querySelector('#different').checked = false;              
              document.querySelector('#liLivraison').classList.toggle('hide');
            }
            document.querySelector('#different').disabled = true;  
            document.querySelector('#solo').classList.add('hide');          
          }
          if(document.querySelector('input[type=radio][name=expedition][value=colissimo]').checked) {            
            document.querySelector('#different').disabled = false;
            if(document.querySelector('#different').checked) {
              document.querySelector('#solo').classList.add('hide');
            } else {
              document.querySelector('#solo').classList.remove('hide');
            }          
          } 
          getDetails()
        });
      });
      document.querySelector('#form').addEventListener('submit', () => {
        const button = document.querySelector('#commande');
        button.classList.toggle('disabled');
        button.textContent = 'Confirmation de la commande en cours, ne fermez pas cette fenêtre...'
      });
      changePayment();
      getDetails();
    });
  </script>
@endsection