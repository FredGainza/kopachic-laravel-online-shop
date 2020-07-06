<div class="card-content">
    @csrf
    <div class="row col s12">
        <label>
            <input type="checkbox" name="professionnal" id="professionnal"
                {{ old('professionnal', isset($adress) ? $adress->professionnal : false) ? 'checked' : '' }}>
            <span>C'est une adresse professionnelle</span>
        </label>
    </div>
    <div class="row col s12">
        <label>
            <input name="civility" type="radio" value="Mme"
                {{ old('civility', isset($adress) ? $adress->civility : '') == 'Mme' ? 'checked' : '' }} />
            <span>Mme.</span>
        </label>
        <label>
            <input name="civility" type="radio" value="M."
                {{ old('civility', isset($adress) ? $adress->civility : '') == 'M.' ? 'checked' : '' }} />
            <span>M.</span>
        </label>
    </div>
    <x-input name="name" type="text" icon="person" label="Nom" :value="isset($adress) ? $adress->name : ''"></x-input>
    <x-input name="firstname" type="text" icon="person" label="Prénom"
        :value="isset($adress) ? $adress->firstname : ''"></x-input>
    <x-input name="company" type="text" icon="business" label="Raison sociale"
        :value="isset($adress) ? $adress->company : ''"></x-input>
    <x-input name="address" type="text" icon="home" label="N° et libellé de la voie"
        :value="isset($adress) ? $adress->address : ''" required="true"></x-input>
    <x-input name="addressbis" type="text" icon="home" label="Bâtiment, Immeuble (optionnel)"
        :value="isset($adress) ? $adress->addressbis : ''"></x-input>
    <x-input name="bp" type="text" icon="location_on" label="Lieu-dit ou BP (optionnel)"
        :value="isset($adress) ? $adress->bp : ''"></x-input>
    <x-input name="postal" type="text" icon="location_on" label="Code postal"
        :value="isset($adress) ? $adress->postal : ''" required="true"></x-input>
    <x-input name="city" type="text" icon="location_on" label="Ville" :value="isset($adress) ? $adress->city : ''"
        required="true"></x-input>
    <div class="row">
        <div class="input-field col s12">
            <i class="material-icons prefix">location_on</i>
            <select name="country_id"">
          @foreach($countries as $country)
            <option 
              value=" {{ $country->id }}" @if(old('country_id', isset($adress) ? $adress->country_id : '') ==
                $country->id) selected @endif>{{ $country->name }}
                </option>
                @endforeach
            </select>
            <label>Pays</label>
        </div>
    </div>
    <x-input name="phone" type="text" icon="phone" label="N° de téléphone" :value="isset($adress) ? $adress->phone : ''"
        required="true"></x-input>
    <p>
        @if($addresses->count() >= 1)
            <div class="row col s12">
                <span>Adresse principale : </span>
                <label>
                    <input name="principale" type="radio" value="1"
                    @if(isset($adress))
                        {{ old('principale', ($user->principale == $adress->id)) ? 'checked' : '' }} @endif />
                    <span>Oui</span>
                </label>
                <label>
                    <input name="principale" type="radio" value="0"
                    @if(isset($adress))
                        {{ old('principale', ($user->principale != $adress->id)) ? 'checked' : '' }} @endif />                   
                    <span>Non</span>
                </label>
            </div>
        @endif
        <button class="btn waves-effect waves-light" style="width: 100%" type="submit">
            Enregistrer
        </button>
    </p>
</div>