@extends('layouts.app')

@section('content')
<div class="container">
  <h3>{{ $page->title }}</h3>
  <div class="row">
     
    <div class="card">
      <div class="card-content">
        {!! $page->text !!}
      </div>
    </div>
</div>
@endsection