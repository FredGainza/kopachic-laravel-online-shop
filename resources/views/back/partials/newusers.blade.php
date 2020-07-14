<div class="row btn-menu">
    @if(isset($newuser))
    {{-- {{dd($newuser)}}; --}}
        <div class="col-6 col-sm-2 col-xl-1 order-1 m-t-n2">
            <button class="btn btn-block btn-dark btn-menu" onclick="history.back()">Retour</button>
        </div>
        <div class="col-12 col-sm-7 col-lg-6 mx-auto order-3 order-sm-2 mt-3 mt-sm-0">
            <div class="text-center">
                <button class="btn btn-block btn-menu btn-outline-info text-dark"">
                    <span class="fz-110">
                        {{ $newuser->count() }}
                        @if($newuser->count() === 1) nouvel inscrit @else nouveaux inscrits @endif
                    </span>
                </button>
            </div>
        </div>
        <div class="col-6 col-sm-2 col-xl-1 order-2 order-sm-3">
            <form action="{{ route('read', 'users') }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-danger btn-block btn-menu">Purger</button>
            </form>
        </div>

        <table class="table table-bordered table-hover table-sm mt-3 order-4" id="users-table">
            <thead>
                <tr>
                    <th title="Id">Id</th>
                    <th title="Nom">Nom</th>
                    <th title="Prénom">Prénom</th>
                    <th title="Email">Email</th>
                    <th title="Inscription">Inscription</th>
                    <th title="Lettre d'information" class="text-center" max-width="300">Lettre d'information</th>
                    <th title="" min-width="200"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($newuser->sortByDesc('created_at') as $new)
                    <tr>
                        <td>{{ $new->id }}</td>
                        <td>{{ $new->name }}</td>
                        <td>{{ $new->firstname }}</td>
                        <td>{{ $new->email }}</td>
                        <td>{{ $new->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            @if($new->newsletter === 1)
                                <i class="fas fa-check text-success"></i>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('clients.show', $new->id) }}" class="btn btn-sm btn-info btn-block">Voir</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>