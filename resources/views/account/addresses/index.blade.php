@extends('layouts.app')

@section('content')

<div class="container">
  <h2 class="titre">Mes adresses</h2>
  <div class="row">
    @foreach($addresses as $address)
      <div class="col s12 m6 l4">
        <div class="card" {{($user->principale == $address->id ? ' style=background-color:#f7fffe;color:#3a3a3a;' : '') }}>
          <div class="card-content address axx {{($user->principale == $address->id ? ' p-t-0' : '') }}">
            @include('account.addresses.partials.address')
          </div>
          <div class="card-action">
            <a href="{{ route('adresses.edit', $address->id) }}">Mettre à jour</a>
            <a class="delete" href="{{ route('adresses.destroy', $address->id) }}">Supprimer</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <div class="row">
    @if(url()->previous() === route('commandes.create'))
      <a class="waves-effect waves-light btn m-l-1 pos-btn left m-small" href="{{ route('commandes.create') }}">Retour à ma commande</a>      
    @else
      <a class="waves-effect waves-light btn m-l-1 pos-btn left m-small" href="{{ route('account') }}">Retour à mon compte</a>
    @endif
    <a class="waves-effect waves-light btn m-l-1 center-on-small-only pos-btn" href="{{ route('adresses.create') }}">Créer une adresse</a>
  </div>
</div>
@endsection

@section('javascript')
  <script>
      const del = async url => {
        const response = await fetch(url, { 
          method: 'DELETE',
          headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        location.reload(true);        
      };
      document.addEventListener('DOMContentLoaded', () => {
        @if(session()->has('alert'))
          M.toast({ html: '{{ session('alert') }}' });
        @endif
        const deleteButtons = document.querySelectorAll('.delete');
        deleteButtons.forEach( button => {
          button.addEventListener('click', e => {
            e.preventDefault();
            del(e.target.getAttribute('href'));
          });
        });
      });
    
  </script>
@endsection