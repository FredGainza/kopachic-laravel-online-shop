@extends('layouts.app')

@section('css')
  <style>
    .wshow{
      width: 100% !important;
    }
    .m-btn-ajout{
      margin-top: .8rem;
    }
    @media screen and (min-width: 479px) and (max-width: 600px){
      .wshow{
        width: 45% !important;
      }
      .align-qte{
        margin-left: 0 !important;
      }
      .align-btn{
        margin-left: 8% !important;
        margin-right: 0 !important
      }
      .m-btn-ajout{
        margin-top: 0;
      }
    }
    .modal .modal-footer{
      height: auto;
    }
  </style>    
@endsection

@section('content')
<div class="container">

  @if(session()->has('cart'))
    <div class="modal">
      <div class="modal-content p-b-0-5 center-align">
        <h5>Produit ajouté au panier avec succès</h5>
        <hr>
        <p>Il y a {{ $cartCount }} @if($cartCount > 1) articles @else article @endif dans votre panier pour un total de <b>{{ number_format($cartTotal, 2, ',', ' ') }}&nbsp;€&nbsp;TTC</b> hors frais de port.</p>
        <p><em>Vous avez la possibilité de venir chercher vos produits sur place, dans ce cas vous cocherez la case correspondante lors de la confirmation de votre commande et aucun frais de port ne vous sera facturé.</em></p>
        <div class="modal-footer center-align">     
          <button class="modal-close btn waves-effect waves-light pos-btn-100 left" id="continue">
            Continuer mes achats
          </button>
          <a href="{{ route('panier.index') }}" class="btn waves-effect waves-light center-on-small-only pos-btn-100 p-small">
            Commander          
          </a>
        </div>
      </div>
    </div>
  @endif

  <div class="row m-t-1-5">
    <div class="col s12 m6 center-align">
      <img style="max-height:600px;max-width:90%;width:auto;margin-top:auto;margin-bottom:auto;" src="/images/{{ $product->image }}">
    </div>
    <div class="col s12 m6">
      <h4 class="m-b-0">{{ $product->name }}</h4>
      <h6 class="italic">{{ $product->category->name }}</h6>
      <p><strong>{{ number_format($product->price, 2, ',', ' ') }} € TTC</strong></p>
      <p>{{ $product->description }}</p>
      <form  method="POST" action="{{ route('panier.store') }}">
        @csrf
        <div class="input-field m-y-2-5">
          <input type="hidden" id="id" name="id" value="{{ $product->id }}">
          <input id="quantity" class="wshow align-qte" name="quantity" type="number" value="1" step="1" min="1">
          <label for="quantity">Quantité</label>        

          <button class="btn waves-effect waves-light wshow align-btn nowrape m-btn-ajout" type="submit" id="addcart">Ajouter au panier
            <i class="material-icons left">add_shopping_cart</i>
          </button>
 
        </div>    
      </form>
    </div>
  </div>
</div>
@endsection

@section('javascript')
  <script>
    @if(session()->has('cart'))
      document.addEventListener('DOMContentLoaded', () => {      
        const instance = M.Modal.init(document.querySelector('.modal'));
        instance.open();    
      });
    @endif    
  </script>
@endsection