@if(isset($user) && $user->addresses()->count() >= 1 && $user->principale == $address->id && url()->current() != "https://kopachic.fgainza.fr/commandes/creation")
    <ul class="list-unstyled m-x-0">
        <li class="center-align card-panel p-y-0-5 m-x-n1-6 teal fz-110 lighten-2 white-text"><strong> Adresse principale</strong></li>
@else 
    <ul class="list-unstyled p-t-1">
@endif
        @isset($address->name)
            <li>{{ "$address->civility $address->name $address->firstname" }}</li>
        @endif
        @if($address->company)
            <li>{{ $address->company }}</li>
        @endif            
        <li>{{ $address->address }}</li>
        @if($address->addressbis)
            <li>{{ $address->addressbis }}</li>
        @endif
        @if($address->bp)
            <li>{{ $address->bp }}</li>
        @endif
        <li>{{ "$address->postal $address->city" }}</li>
        <li>{{ $address->country->name }}</li>
        <li>{{ $address->phone }}</li>
    </ul>