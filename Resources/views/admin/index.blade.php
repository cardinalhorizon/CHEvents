@extends('chevents::layouts.admin')

@section('title', 'CHEvents')
@section('actions')
  <li>
    <a href="{{ route('admin.chevents.create') }}">
      <i class="ti-plus"></i>
      Add New</a>
  </li>
@endsection
@section('content')
  <div class="card border-blue-bottom">
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            @include('flash::message')
            <div class="table-responsive">
              <table class="table table-hover table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Starting At</th>
                  <th>Ending At</th>
                  <th>Users</th>
                  <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($events as $event)
                  <tr>
                    <td>{{$event->name}}</td>
                    <td>
                      {{$event->starting_at}}
                    </td>
                    <td>
                      {{$event->ending_at}}
                    </td>
                    <td>
                      {{$event->users->count()}}
                    </td>
                    <td class="text-right">
                      <a href="{{ route('admin.chevents.show', [$event->id]) }}" class="btn btn-primary">View</a>
                      <a href="{{ route('admin.chevents.edit', [$event->id]) }}" class="btn btn-info">Edit</a>
                    </td>
                  </tr>
                @endforeach

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 text-center">
          {{ $events->withQueryString()->links('admin.pagination.default') }}
        </div>
      </div>
    </div>
  </div>



@endsection
