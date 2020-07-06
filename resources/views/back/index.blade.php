@extends('back.layout') 

@section('main') 
  <div class="container-fluid">
    @if(app()->isDownForMaintenance())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        La boutique est en mode maintenance !
      </div>
    @endif

    @if(isset($newcom))    
      @include('back.partials.neworders')    
    @endif

    @if(isset($newuser))    
      @include('back.partials.newusers')    
    @endif


    @if(isset($notifications) && $notifications->count())
      <div class="row">
        @if(isset($newOrders))
          <div class="col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $newOrders }}</h3>
                <p>@if($newOrders === 1) Nouvelle commande @else Nouvelles commandes @endif</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-bag"></i>
              </div>
              @if($newOrders > 0)
                <a href="{{route('vieworders')}}" class="small-box-footer">Plus d'informations <i class="fas fa-arrow-circle-right"></i></a>
                <form action="{{ route('read', 'orders') }}" method="POST">
                  @csrf
                  @method('PUT')
                  <button type="submit" class="btn btn-info btn-block text-warning">Purger</button>
                </form>
              @endif
            </div>
          </div>
        @endif
        @if(isset($newUsers))
          <div class="col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $newUsers }}</h3>
                <p>@if($newUsers === 1) Nouvel inscrit @else Nouveaux inscrits @endif</p>
              </div>
              <div class="icon">
                <i class="fas fa-user"></i>
              </div>
              @if($newUsers > 0)
              <a href="{{ route('viewusers') }}" class="small-box-footer">Plus d'informations <i class="fas fa-arrow-circle-right"></i></a>
                <form action="{{ route('read', 'users') }}" method="POST">
                  @csrf
                  @method('PUT')
                  <button type="submit" class="btn btn-success btn-block text-warning">Purger</button>
                </form>
              @endif
            </div>
          </div>
        @endif
      </div>
      @endif

  </div>
@endsection