@extends('back.layout')
@section('css')
  <style>
    .custom-file-label::after { content: "Parcourir"; }
  </style>
@endsection
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
        
          <form method="POST" action="@isset($product) {{ route('produits.update', $product->id) }} @else {{ route('produits.store') }} @endisset" enctype="multipart/form-data">
            <div class="card-body">
              @isset($product) @method('PUT') @endisset
              @csrf   
              
              <x-inputbs4
                name="name"
                type="text"
                label="Nom"
                :value="isset($product) ? $product->name : ''"
              ></x-inputbs4>

              <label>Categorie</label>
              <select id="category_id" name="category_id" class="custom-select custom-select-md mb-3">
                <option value="#" selected>--- Choisir une catégorie ---</option>
                @foreach($categories as $category)
                  <option 
                  value=" {{ $category->id }}" @if(old('category_id', isset($product) ? $product->category_id : '') == $category->id) selected @endif>{{ $category->name }}
                  </option>
                    {{-- <option value="{{ $category->id }}" @isset($product) <?= $product->category_id == $category->id ? "selected" : ""; ?> @endisset >{{ $category->name }}</option> --}}
                @endforeach
              </select>

              <x-textareabs4
                name="description"
                label="Description"
                :value="isset($product) ? trim($product->description) : ''"></x-textareabs4>
              <x-inputbs4
                name="weight"
                type="text"
                label="Poids en kg"
                :value="isset($product) ? $product->weight : ''"
                required="true"
              ></x-inputbs4>
              <x-inputbs4
                name="price"
                type="text"
                label="Prix TTC"
                :value="isset($product) ? $product->price : ''"
                required="true"
              ></x-inputbs4>
              <x-inputbs4
                name="quantity"
                type="number"
                label="Quantité disponible"
                :value="isset($product) ? $product->quantity : ''"
                required="true"
              ></x-inputbs4>
        
              <x-inputbs4
                name="quantity_alert"
                type="number"
                label="Quantité pour alerte stock"
                :value="isset($product) ? $product->quantity_alert : ''"
                required="true"
              ></x-inputbs4>
              <div class="form-group{{ $errors->has('image') ? ' is-invalid' : '' }}">
                <label for="description">Image</label>
                @if(isset($product) && !$errors->has('image'))
                  <div>
                    <p><img src="{{ asset('images/thumbs/' . $product->image) }}"></p>
                    <button id="changeImage" class="btn btn-warning">Changer d'image</button>
                  </div>
                @endif
                <div id="wrapper">
                  @if(!isset($product) || $errors->has('image'))
                    <div class="custom-file">
                      <input type="file" id="image" name="image"
                            class="{{ $errors->has('image') ? ' is-invalid ' : '' }}custom-file-input" required>
                      <label class="custom-file-label" for="image"></label>
                      @if ($errors->has('image'))
                        <div class="invalid-feedback">
                          {{ $errors->first('image') }}
                        </div>
                      @endif
                    </div> 
                  @endif
                </div>
              </div>
              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="active" name="active" @if(old('active', isset($product) ? $product->active : false)) checked @endif>
                  <label class="custom-control-label" for="active">Produit actif</label>
                </div>
              </div>
              <div class="form-group row mb-0">
                <div class="col-md-12">
                  <a class="btn btn-dark" href="{{ route('produits.index') }}" role="button"><i class="fas fa-arrow-left"></i> Retour à la liste des produits</a>
                   <button type="submit" class="btn btn-dark">Enregistrer</button>
                </div>
              </div>
              
            </div>            
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('js')
  <script>
    $(document).ready(() => {
      $('form').on('change', '#image', e => {
        $(e.currentTarget).next('.custom-file-label').text(e.target.files[0].name);
      });
      $('#changeImage').click(e => {
        $(e.currentTarget).parent().hide();
        $('#wrapper').html(`
          <div id="image" class="custom-file">
            <input type="file" id="image" name="image" class="custom-file-input" required>
            <label class="custom-file-label" for="image"></label>
          </div>`
        );
      });
    });
  </script>
@endsection