@extends('chevents::layouts.admin')

@section('title', 'CHEvents > '.$event->name)
@section('actions')
  <li>
    <a href="{{ route('admin.chevents.users.index', $event) }}">
      <i class="ti-pencil"></i>
      Edit Users</a>
  </li>
  <li>
    <a href="{{ route('admin.chevents.pireps.index', $event) }}">
      <i class="ti-pencil"></i>
      Edit PIREPs</a>
  </li>
  <li>
    <a href="{{ route('admin.chevents.edit', $event) }}">
      <i class="ti-pencil"></i>
      Edit Event</a>
  </li>
  <li>
    <a class="btn btn-danger" href="#" onclick="event.preventDefault(); if (confirm('Are you sure you want to delete this event?'))
                                    document.getElementById('destroy_event').submit();">
      <i class="ti-pencil"></i>
      Delete Event</a>
    <form id="destroy_event" method="POST" action="{{ route('admin.chevents.destroy', $event) }}" accept-charset="UTF-8" hidden>
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
    </form>
  </li>
@endsection
@section('content')
  <div class="card border-blue-bottom">
    <div class="content">
      <h2>{{$event->name}}</h2>
      <div class="row">
        <div class="col-sm-6">
          <div style="background: #ccc; padding: 5px; font-size: 24px;">
            Description
          </div>
          <div style="height: 500px; overflow-y: scroll;">
            {!! $event->description !!}
          </div>
        </div>
        <div class="col-sm-6">
          @if($event->banner_url)
          <div style="background: #ccc; padding: 5px; font-size: 24px;">
            Event Banner
          </div>
          <div style="margin: 1rem;">
            <img style="display: block; width: 100%;" src="{{$event->banner_url}}" alt="Image Not Found"/>
          </div>
          @endif
          <div style="background: #ccc; padding: 5px; font-size: 24px;">
            Details
          </div>
          <div class="">
            <div class="d-flex flex-row justify-content-between">
              <div>Starting At</div>
              <div>{{$event->starting_at}}</div>
            </div>
            <div class="d-flex flex-row justify-content-between">
              <div>Ending At</div>
              <div>{{$event->ending_at}}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-sm-12">
      <div class="card border-blue-bottom">
        <div class="content">
          <div class="row">
            <div class="col-xs-5">
              <div class="icon-big icon-info text-center">
                <i class="pe-7s-users"></i>
              </div>
            </div>
            <div class="col-xs-7">
              <div class="numbers">
                <p>Users</p>
                  <a href="{{ route('admin.chevents.users.index', $event) }}">
                    {{$event->users->count()}}
                  </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-sm-12">
      <div class="card border-blue-bottom">
        <div class="content">
          <div class="row">
            <div class="col-xs-5">
              <div class="icon-big icon-info text-center">
                <i class="pe-7s-cloud-upload"></i>
              </div>
            </div>
            <div class="col-xs-7">
              <div class="numbers">
                <p>PIREPs</p>
                  <a href="{{ route('admin.chevents.pireps.index', $event) }}">
                    {{$pireps->count()}}
                  </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
