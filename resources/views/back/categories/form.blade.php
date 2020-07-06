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
        
          <form method="POST" action="@isset($category) {{ route('categories.update', $category->id) }} @else {{ route('categories.store') }} @endisset">
            <div class="card-body">
              @isset($category) @method('PUT') @endisset
              @csrf
          
                <x-inputbs4
                  name="name"
                  type="text"
                  label="Nom"
                  :value="isset($category) ? $category->name : ''"
                ></x-inputbs4>
                <x-inputbs4
                  name="slug"
                  type="text"
                  label="Slug"
                  :value="isset($category) ? $category->slug : ''"
                ></x-inputbs4>
              </div>
            </div>      
            <div class="form-group row mb-0">
              <div class="col-md-12">
                <a class="btn btn-dark" href="{{ route('categories.index') }}" role="button"><i class="fas fa-arrow-left"></i> Retour à la liste des catégories</a>
                <button type="submit" class="btn btn-dark">Enregistrer</button>          
              </div>
            </div>
              
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection