@extends('chevents::layouts.frontend')

@section('title', 'Events')

@section('content')
  <div class="row">
    @include('flash::message')
    <div class="col-md-12">
      <h2>Events</h2>
      @include('chevents::frontend.table')
    </div>
  </div>
  <div class="row">
    <div class="col-12 text-center">
      {{ $events->withQueryString()->links('pagination.default') }}
    </div>
  </div>
@endsection
