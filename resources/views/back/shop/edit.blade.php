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
        
          <form method="POST" action="#">
            <div class="card-body">
              @method('PUT')
              @csrf
              <div class="card">
                <h5 class="card-header">Identité</h5>
                <div class="card-body">
          
                  <x-inputbs4
                    name="name"
                    type="text"
                    label="Nom"
                    :value="$shop->name"
                  ></x-inputbs4>
                  <x-inputbs4
                    name="address"
                    type="text"
                    label="Adresse"
                    :value="$shop->address"
                  ></x-inputbs4>
                  <x-inputbs4
                    name="email"
                    type="email"
                    label="Email"
                    :value="$shop->email"
                  ></x-inputbs4>
                  
                  <x-inputbs4
                    name="phone"
                    type="text"
                    label="Téléphone"
                    :value="$shop->phone"
                  ></x-inputbs4>
                  <x-inputbs4
                    name="facebook"
                    type="text"
                    label="Facebook"
                    :value="$shop->facebook"
                  ></x-inputbs4>
                </div>
              </div>
              <div class="card">
                <h5 class="card-header">Banque</h5>
                <div class="card-body">
          
                  <x-inputbs4
                    name="holder"
                    type="text"
                    label="Titulaire"
                    :value="$shop->holder"
                  ></x-inputbs4>
                  <x-inputbs4
                    name="bank"
                    type="text"
                    label="Nom"
                    :value="$shop->bank"
                  ></x-inputbs4>
                  <x-inputbs4
                    name="bank_address"
                    type="text"
                    label="Adresse"
                    :value="$shop->bank_address"
                  ></x-inputbs4>
                  <x-inputbs4
                    name="bic"
                    type="text"
                    label="BIC"
                    :value="$shop->bic"
                  ></x-inputbs4>
                  <x-inputbs4
                    name="iban"
                    type="text"
                    label="IBAN"
                    :value="$shop->iban"
                  ></x-inputbs4>
                </div>
              </div>
              <div class="card">
                <h5 class="card-header">Accueil</h5>
                <div class="card-body">
          
                  <x-inputbs4
                    name="home"
                    type="text"
                    label="Titre"
                    :value="$shop->home"
                  ></x-inputbs4>
                  <x-textareabs4
                    name="home_infos"
                    label="Informations importantes"
                    :value="$shop->home_infos"
                  ></x-textareabs4>
                  <x-textareabs4
                    name="home_shipping"
                    label="Frais d'expédition"
                    :value="$shop->home_shipping"
                  ></x-textareabs4>
                </div>
              </div>
              <div class="card">
                <h5 class="card-header">Facturation</h5>
                <div class="card-body">
                  <x-checkbox
                    name="invoice"
                    label="Activation de la facturation"
                    :value="$shop->invoice"
                  ></x-checkbox>
                  
                </div>
              </div>
              <div class="card">
                <h5 class="card-header">Modes de paiement acceptés</h5>
                <div class="card-body">
                  <x-checkbox
                    name="card"
                    label="Carte bancaire"
                    :value="$shop->card"
                  ></x-checkbox>

                  <x-checkbox
                    name="paypal"
                    label="Paypal"
                    :value="$shop->paypal"
                  ></x-checkbox>
                  
                  <x-checkbox
                    name="transfer"
                    label="Virement"
                    :value="$shop->transfer"
                  ></x-checkbox>
                  
                  <x-checkbox
                    name="check"
                    label="Chèque"
                    :value="$shop->check"
                  ></x-checkbox>
                  
                  <x-checkbox
                    name="mandat"
                    label="Mandat administratif"
                    :value="$shop->mandat"
                  ></x-checkbox>
                
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