<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  </head>
  <body>
    <h2>{{ $shop->name }}</h2>
    <p>{{ $user->name }} {{ $user->firstname }}</p>
    <p>{{ \Carbon\Carbon::now() }}</p>
    <h3>Informations générales</h3>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Nom</th>
          <th scope="col">Prénom</th>
          <th scope="col">E-mail</th>
          <th scope="col">Création du compte</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ $user->name }}</td>
          <td>{{ $user->firstname }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->created_at->calendar() }}</td>
        </tr>
      </tbody>
    </table>
    <h3>Adresses</h3>
    @foreach($user->addresses as $address)
      <table class="table table-bordered table-striped table-sm">
        <tbody>
          @isset($address->name)
            <tr>
              <td><strong>Nom</strong></td>
              <td>{{ "$address->civility $address->name $address->firstname" }}</td>
            </tr>
          @endisset
          @if($address->company)
            <tr>
              <td><strong>Entreprise</strong></td>
              <td>{{ $address->company }}</td>
            </tr>          
          @endif 
          <tr>
            <td><strong>Adresse</strong></td>
            <td>{{ $address->address }}</td>
          </tr>
          @if($address->addressbis)
            <tr>
              <td><strong>Adresse complément</strong></td>
              <td>{{ $address->addressbis }}</td>
            </tr>     
          @endif
          @if($address->bp)
            <tr>
              <td><strong>Boîte postale</strong></td>
              <td>{{ $address->bp }}</td>
            </tr>
          @endif
          <tr>
            <td><strong>Ville</strong></td>
            <td>{{ "$address->postal $address->city" }}</td>
          </tr>
          <tr>
            <td><strong>Pays</strong></td>
            <td>{{ $address->country->name }}</td>
          </tr>
          <tr>
            <td><strong>Téléphone</strong></td>
            <td>{{ $address->phone }}</td>
          </tr>
        </tbody>
      </table>
    @endforeach
    <h3>Commandes</h3>
    @foreach($user->orders as $order)
      <table class="table table-bordered table-striped table-sm">
        <thead>
          <tr>
            <th>Référence</th>
            <th>Date</th>
            <th>Prix total</th>
            <th>Paiement</th>
            <th>État</th>
          </tr>
        </thead>    
        <tbody>        
          <tr>
            <td>{{ $order->reference }}</td>
            <td>{{ $order->created_at->calendar() }}</td>
            <td>{{ number_format($order->total + $order->shipping, 2, ',', ' ') }} €</td>
            <td>{{ $order->payment_text }}</td>
            <td>{{ $order->state->name }}</td>
          </tr>
        </tbody>
      </table>
      <h5>Détails de la commande</h5>
      <table class="table table-bordered table-striped table-sm">
        @foreach ($order->products as $item)
          <tr>
            <td>{{ $item->name }} ({{ $item->quantity }} @if($item->quantity > 1) exemplaires) @else exemplaire) @endif</td>
            <td>{{ number_format($item->total_price_gross, 2, ',', ' ') }} €</td>
          </tr>
        @endforeach
        <tr>
          <td>Livraison en Colissimo</td>
          <td>{{ number_format($order->shipping, 2, ',', ' ') }}€</td>
        </tr>
        <tr>
          <td>Total TTC (TVA à {{ $item->tax * 100 }} %)</td>
          <td>{{ number_format($order->total + $order->shipping, 2, ',', ' ') }} €</td>
        </tr>
      </table>
      <hr>
    @endforeach
    <h3>Lettre d'information</h3>
    @if($user->newsletter)
      <p>Vous êtes inscrit à la lettre d'information.</p>
    @else
      <p>Vous n'êtes pas inscrit à la lettre d'information.</p>
    @endif
  </body>
</html>