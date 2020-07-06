@extends('back.layout')
@section('main') 
  <div class="container-fluid"> 
    @if(session()->has('alert'))
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('alert') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <h5 class="card-header">Mode maintenance</h5>        
          <form method="POST" action="{{ route('maintenance.update') }}">
            <div class="card-body">
              @method('PUT')
              @csrf
              <x-inputbs4
                name="ip"
                type="text"
                label="Adresse IP autorisée"
                :value="$ip"
                :required="true"
              ></x-inputbs4>
              <x-inputbs4
                name="message"
                type="text"
                label="Message à afficher"
                :value="$message"
                :required="true"
              ></x-inputbs4>
              <x-checkbox-custom
                name="active"
                label="Mode maintenance"
                off="success"
                on="danger"
                :value="$active"
              ></x-checkbox-custom>
              <div class="form-group row mb-0">
                <div class="col-md-12">
                   <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
              </div>              
            </div>            
          </form>
        </div>
      </div>

      <div class="col-sm-12">
        <div class="card">
          <h5 class="card-header">Cache</h5>        
          <form method="POST" action="{{ route('cache.update') }}">
            <div class="card-body">
              @method('PUT')
              @csrf
              <x-checkbox-custom
                name="config"
                label="Cache de la configuration"
                off="info"
                on="warning"
                :value="$config"
              ></x-checkbox-custom>
              <x-checkbox-custom
                name="route"
                label="Cache des routes"
                off="info"
                on="warning"
                :value="$route"
              ></x-checkbox-custom>
              <div class="form-group row mb-0">
                <div class="col-md-12">
                   <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
              </div>              
            </div>            
          </form>
        </div>
      </div>  
      
    </div>
  </div>
@endsection