@extends('back.layout')

@section('css')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endsection

@section('main') 
  {{ $dataTable->table(['class' => 'table table-bordered table-hover table-sm'], true) }}
  @if(Route::currentRouteName() === 'pays.index')
    <a class="btn btn-dark" href="{{ route('pays.create') }}" role="button">Créer un nouveau pays</a>
  @elseif(Route::currentRouteName() === 'etats.index')
    <a class="btn btn-dark" href="{{ route('etats.create') }}" role="button">Créer un nouvel état</a>
  @elseif(Route::currentRouteName() === 'pages.index')
    <a class="btn btn-dark" href="{{ route('pages.create') }}" role="button">Créer une nouvelle page</a>
  @elseif(Route::currentRouteName() === 'categories.index')
    <a class="btn btn-dark" href="{{ route('categories.create') }}" role="button">Créer une nouvelle catégorie</a>
  @endif
@endsection

@section('js') 
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script> 
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script> 
  {{ $dataTable->scripts() }}
  
@endsection