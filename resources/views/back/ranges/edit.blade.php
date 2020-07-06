@extends('back.layout')

@section('main') 
  <div class="container-fluid"> 
      @if(session()->has('alert'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('alert') }}
      @else
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Si vous supprimez une plage les valeurs correspondantes dans les tarifs des expéditions par pays seront aussi supprimées. Il est vivement conseillé d'effecteur ces modifications en mode maintenance !
      @endif
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
        
          <form method="POST" action="{{ route('plages.update') }}">
            <div class="card-body">
              @method('PUT')
              @csrf
              <div class="card">
                <h5 class="card-header">Plages</h5>
                <div class="card-body">
          
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Poids maximum</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($ranges as $range)
                        <tr>
                          <td>Plage {{ $loop->iteration }}</td>
                          <td><input name="{{ $loop->iteration }}" type="text" class="form-control max" value="{{ $range->max }}"></td>
                          <td>@if($loop->last) <button type="button" class="btn btn-danger btn-block">Supprimer</button> @endif</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="form-group row mb-0">
                <div class="col-md-12">
                   <button type="submit" class="btn btn-dark">Enregistrer</button>
                   <button class="btn btn-success float-right">Ajouter une plage</button>
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
    let ranges = [];
    const checkValue = (indice, value) => {
      if(isNaN(value)) {
        return false;
      }
      if(indice) {
        if(value < ranges[indice - 1]) {
          return false;
        }
      }
      if(indice < ranges.length) {
        if(value > ranges[indice + 1]) {
          return false;
        }
      }
      return true;
    }
    $(document).ready(() => {
      $('.max').each((index, element) => {
        ranges.push(Number($(element).val()))        
      });
      $(document).on('change', 'input', e => {
        const indice = $(e.currentTarget).attr('name') - 1;
        const value = $(e.currentTarget).val();
        if(checkValue(indice, value)) {
          ranges[indice] = value;
        } else {
          $('input[name=' + (indice + 1) + ']').val(ranges[indice]);
          $(e.currentTarget).removeClass('is-invalid');
          $('button[type=submit]').removeClass('disabled');
        }      
      });
      $(document).on('input', 'input', e => {
        const indice = $(e.currentTarget).attr('name') - 1;
        const input = $('input[name=' + (indice + 1) + ']');
        if(checkValue(indice, $(e.currentTarget).val())) {
          input.removeClass('is-invalid');
          $('button[type=submit]').removeClass('disabled');
        } else {
          input.addClass('is-invalid');
          $('button[type=submit]').addClass('disabled');
        }
      });
      $(document).on('click', 'button.btn-danger', e => {
        $('input[name=' + (ranges.length) + ']').parent().parent().remove();
        ranges.pop();
        if(ranges.length) {
          $('input[name=' + (ranges.length) + ']').parent().next().html(
            '<button type="button" class="btn btn-danger btn-block">Supprimer</button>'
          );
        }     
      });
      $('button.btn-success').click(e => {
        e.preventDefault();
        $('input[name=' + (ranges.length) + ']').parent().next().html('');
        ranges.push(Number(ranges[ranges.length - 1]) + 1);        
        const html = `
        <tr>
          <td>Plage ${ranges.length}</td>
          <td><input name="${ranges.length}" type="text" class="form-control max" value="${ranges[ranges.length - 1]}"></td>
          <td><button type="button" class="btn btn-danger btn-block">Supprimer</button></td>
        </tr>
        `;
        $('tbody').append(html);
      });
      
    });
  </script>
@endsection