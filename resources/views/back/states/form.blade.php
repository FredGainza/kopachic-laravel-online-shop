@extends('back.layout')
@section('main') 
  <div class="container-fluid"> 
    @if(session()->has('alert'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('alert') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
        
          <form method="POST" action="@isset($state) {{ route('etats.update', $state->id) }} @else {{ route('etats.store') }} @endisset">
            <div class="card-body">
              @isset($state) @method('PUT') @endisset
              @csrf
          
                <x-inputbs4
                  name="name"
                  type="text"
                  label="Nom"
                  :value="isset($state) ? $state->name : ''"
                  required="true"
                ></x-inputbs4>
                <x-inputbs4
                  name="slug"
                  type="text"
                  label="Slug"
                  :value="isset($state) ? $state->slug : ''"
                  required="true"
                ></x-inputbs4>
                <x-inputbs4
                  name="indice"
                  type="number"
                  label="Indice"
                  :value="isset($state) ? $state->indice : ''"
                  required="true"
                ></x-inputbs4>
                <label>Couleur</label>
                <select id="color" name="color" class="custom-select custom-select-md mb-3">
                  <option value="red" @if(isset($state) && $state->color === 'red') selected @endif>Rouge</option>
                  <option value="blue" @if(isset($state) && $state->color === 'blue') selected @endif>Bleu</option>
                  <option value="green" @if(isset($state) && $state->color === 'green') selected @endif>Vert</option>
                </select>
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-md-12">
                <a class="btn btn-dark" href="{{ route('etats.index') }}" role="button"><i class="fas fa-arrow-left"></i> Retour à la liste des états</a>
                <button type="submit" class="btn btn-dark">Enregistrer</button>
              </div>
            </div>
              
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection