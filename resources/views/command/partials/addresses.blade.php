@if(!$addresses->count())
  <p>Vous n'avez pas encore créé d'adresse dans votre compte, vous devez en créer au moins une.</p>
  <br>
  <p><a href="#" style="width: 100%" class="btn waves-effect waves-light">Je crée une adresse</a>
  </p>
@else
  <div class="row">
    @foreach($addresses as $address)
      <div class="col m12 l6">
        <div class="card">                          
          <div class="card-content address">
            <p><label><input name="{{ $name }}" value="{{ $address->id }}" type="radio" @if($loop->first) checked @endif><span></span></label></p>
            @include('account.addresses.partials.address')
          </div>
        </div>
      </div>
    @endforeach
  </div>                  
@endif