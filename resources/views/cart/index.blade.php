@extends('layouts.app')

@section('css')
  <style>

    input[type="number"]:not(.browser-default){
      border-bottom: none !important;
    }

    .hr105{
      width: 105%;
      height: 0.1px;
      margin-left: -2.5%;
    }
    @media only screen and (min-width: 993px){
      .hr105{
        width: 100% !important;
        margin-left: auto;
        margin-right: auto;
      }
    }

    .lh075{
      line-height: .75 !important;
    }

    .mb10px{
      margin-bottom: 10px !important;
    }

    .wlink{
      width: 100%
    }

  </style>
@endsection

@section('content')
<div class="container">
  <div class="row">
    <div class="col s12">
      <div class="card">        
        <div class="card-content">
          <div id="wrapper">          
            @if($total)
              <span class="card-title m-b-1">Mon panier</span>            
              @foreach ($content as $item)
                <hr class="hr105"><br class="lh075">
                <div class="row mb10px nowrape w-100">
                  <form action="{{ route('panier.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col s6" style="line-height: 1.5">{{ $item->name }}</div>
                    <div class="col s3" style="line-height: 1.5"><strong>{{ number_format($item->quantity * $item->price, 2, ',', ' ') }} €</strong></div>
                    <div class="col s2" style="line-height: 1.5">
                      <input name="quantity" type="number" style="height: 1.5rem" min="1" value="{{ $item->quantity }}">
                    </div>
                  </form>
                  <form action="{{ route('panier.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="col s1" style="line-height: 1.5"><i class="material-icons deleteItem" style="cursor: pointer">delete</i></div>
                  </form>              
                </div>
              @endforeach
              <hr class="hr105"><br class="lh075">
              <div class="row w-100" style="background-color: lightgrey">
                <div class="col s6">
                  Total TTC (hors livraison)
                </div>
                <div class="col s6">
                  <strong>{{ number_format($total, 2, ',', ' ') }} €</strong>
                </div>
              </div>
            @else
            <span class="card-title center-align">Le panier est vide</span>
            @endif
          </div>        
          <div id="loader" class="hide">
            <div class="loader"></div>
          </div>
        </div>
        <div id="action" class="card-action">
          <p>
            <a href="{{ route('home') }}">Continuer mes achats</a>
            @if($total)
                <a href="{{ route('commandes.create') }}">Commander</a>
            @endif
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const quantities = document.querySelectorAll('input[name="quantity"]');
      quantities.forEach( input => {
        input.addEventListener('input', e => {
          if(e.target.value < 1) {
            e.target.value = 1;
          } else {
            e.target.parentNode.parentNode.submit();
            document.querySelector('#wrapper').classList.add('hide');
            document.querySelector('#action').classList.add('hide');
            document.querySelector('#loader').classList.remove('hide');
          }
        });
      }); 
      const deletes = document.querySelectorAll('.deleteItem');
      deletes.forEach( icon => {
        icon.addEventListener('click', e => {
          e.target.parentNode.parentNode.submit();
          document.querySelector('#wrapper').classList.add('hide');
          document.querySelector('#loader').classList.remove('hide');
        });
      }); 
    });
    
  </script>
@endsection