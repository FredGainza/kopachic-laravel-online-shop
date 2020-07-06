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
      @if($errors-> isNotEmpty())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          Il y a des erreurs dans les valeurs, veuillez corriger les entrées signalées en rouge.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif    
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
        
          <form method="POST" action="{{ route('colissimos.update') }}">
            <div class="card-body">
              @method('PUT')
              @csrf
              <div class="card">
                <h5 class="card-header">Tarifs des envois en Colissimo par pays et plage de poids</h5>
                <div class="card-body">
          
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Pays</th>
                        @foreach ($ranges as $range)
                          <th><= {{ $range->max }} Kg</th>
                        @endforeach
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($countries as $country)
                        <tr>
                          <td>{{ $country->name }}</td>
                          @foreach ($country->ranges as $range)
                            <td>
                              <input type="text" class="form-control{{ $errors->has('n' . $range->pivot->id) ? ' is-invalid' : '' }}"
         name="n{{ $range->pivot->id }}" value="{{ old('n' . $range->pivot->id, $range->pivot->price) }}" required>                              
                            </td>
                          @endforeach
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="form-group row mb-0">
                <div class="col-md-12">
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