<div class="row">
    @if(isset($newcom))
    {{-- {{dd($newcom)}}; --}}
        <div class="col-6 col-sm-2 col-xl-1 order-1 m-t-n2">
            <button class="btn btn-block btn-dark btn-menu" onclick="history.back()">Retour</button>
        </div>
        <div class="col-12 col-sm-7 col-lg-6 mx-auto order-3 order-sm-2 mt-3 mt-sm-0">
            <div class="text-center">
                <button class="btn btn-block btn-menu btn-outline-info text-dark"">
                    <span class="fz-110">
                        {{ $newcom->count() }}
                        @if($newcom->count() === 1) nouvelle commande @else nouvelles commandes @endif
                    </span>
                </button>
            </div>
        </div>
        <div class="col-6 col-sm-2 col-xl-1 order-2 order-sm-3">
            <form action="{{ route('read', 'orders') }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-danger btn-block btn-menu">Purger</button>
            </form>
        </div>


        <table class="table table-bordered table-hover table-sm mt-5 order-4" id="orders-table">
            <thead>
                <tr>
                    <th title="Id">Id</th>
                    <th title="Référence">Référence</th>
                    <th  title="Client">Client</th>
                    <th title="Total">Total</th>
                    <th  title="Paiement">Paiement</th>
                    <th title="Etat">Etat</th>
                    <th  title="Facture">Facture</th>
                    <th title="Date">Date</th>
                    <th  title="Changement">Changement</th>
                    <th title="" width="60"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($newcom->sortByDesc('created_at') as $new)
                    @foreach($orders as $ord)
                        <?php $ord->id = $new->user_id; ?>
                    @endforeach

                    <tr>
                        <td>{{ $new->id }}</td>
                        <td>{{ $new->reference }}</td>
                        <td>
                            <a href="{{ route('clients.show', $ord->user->id) }}">{{ $ord->user->name }} {{ $ord->user->firstname }}</a>
                        </td>
                        <td>{{ $new->total }}</td>
                        <td>{{ $new->payment }}</td>
                        <td>
                            <span class="badge badge-{{ config('colors.' . $ord->state->color) }}">{{ $ord->state->name }}</span>
                        </td>
                        <td>{{ $new->invoice_id }}</td>
                        <td>{{ $new->created_at->format('d/m/Y') }}</td>
                        <td>{{ $new->updated_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('orders.show', $new->id) }}" class="btn btn-xs btn-info btn-block">Voir</a>
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>
    @endif
</div>