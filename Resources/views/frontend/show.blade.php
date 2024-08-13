@extends('app')
@section('title', 'Event '.$event->name)

@php
  $ch_free_flight = check_module('CHFreeFlight');;
  $ch_trips = check_module('CHTrips');
@endphp

@section('content')
  <div class="row">
    <div class="col-md-8 col-sm-12">
      <h1>
        {{ $event->name }}
      </h1>
    </div>
    <div class="col-md-4 col-sm-12">
      @php

        @endphp
      <div class="float-right">
        @if($event->can_join)
          @if(!$event->users->contains(Auth::user()->id))
            <a class="btn btn-success" href="#" onclick="event.preventDefault();
                                    document.getElementById('join{{ $event->id }}').submit();">Join</a>
            <form id="join{{ $event->id }}" method="POST" action="{{ route('chevents.attach', [$event->id]) }}" accept-charset="UTF-8" hidden>
              @csrf
            </form>
          @else
            <a class="btn btn-danger" href="#" onclick="event.preventDefault();
                                    document.getElementById('leave{{ $event->id }}').submit();">Leave</a>
            <form id="leave{{ $event->id }}" method="POST" action="{{ route('chevents.detach', [$event->id]) }}" accept-charset="UTF-8" hidden>
              {{ method_field('DELETE') }}
              @csrf
            </form>
          @endif
        @endif
        @if($event->can_fly && $event->users->contains(Auth::user()->id))
          <div class="btn-group" role="group">
              <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                Fly Now
              </button>
              <ul class="dropdown-menu">
                @if(\App\Models\Flight::where(['route_code' => $event->route_code, 'visible' => true, 'active' => true])->count() != 0)
                  <li><a class="dropdown-item" href="{{route('frontend.flights.search', ['route_code' => $event->route_code])}}">View Flights</a></li>
                @endif
                @if($ch_free_flight)
                  <li><a href="{{route('chfreeflight.create', ['route_code' => $event->route_code, 'flight_number' => Auth::user()->pilot_id])}}" class="dropdown-item">Create Flight (CHFreeFlight)</a></li>
                @endif
              </ul>
          </div>
        @endif
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-8">
      <div class="row mb-4">
        <div class="col-12">
          @if($event->banner_url)
            <img src="{{$event->banner_url}}" style="width: 100%" alt="{{$event->name}}"/>
          @endif
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          {!! $event->description !!}
        </div>
      </div>
    </div>
    <div class="col-4">
      @if($event->can_fly && $event->route_code !== null)
        <div class="alert alert-success text-center">
          <div style="font-size: 24px; font-weight: 700;">Now Accepting PIREPs</div>
          <div>Use the Flight Code <span style="font-weight: 700; text-decoration: underline">{{$event->route_code}}</span> to submit your PIREP</div>
        </div>
      @elseif(now() <= \Carbon\Carbon::parse($event->starting_at)->subHours(2))
        <div class="alert alert-warning text-center">
          <div style="font-size: 24px; font-weight: 700;">Event Starts in {{\Carbon\Carbon::parse($event->starting_at)->diffForHumans()}}.</div>
          <div>Use the Flight Code <span style="font-weight: 700; text-decoration: underline">{{$event->route_code}}</span> to submit your PIREP</div>
        </div>
      @endif
      <div class="card card-primary text-white dashboard-box">
        <div class="card-body text-center">
          <div style="height: inherit">
            <div class="icon-background">
              <i class="fas fa-users icon"></i>
            </div>
            <h3 class="header" style="font-size: 48px;">{{ $event->users->count() }}</h3>
            <h5>Users Signed Up</h5>
          </div>
          <hr/>
          @foreach($event->users as $user)
            <span class="badge badge-primary">{{$user->ident}} | {{$user->name_private}}</span>
          @endforeach
        </div>
      </div>
      <div class="card mt-4">
        <div class="card-body">
          <h3>PIREPs</h3>
          <div class="table-responsive">
            <table class="table">
              @foreach($event->matrix as $m)
                @if($m->pirep)
                  <tr>
                    <td style="padding-right: 10px;">
                      <span class="title">{{ $m->pirep->ident }}</span>
                    </td>
                    <td>
                      <a href="{{route('frontend.airports.show', [$m->pirep->dpt_airport_id])}}">{{$m->pirep->dpt_airport_id}}</a>
                      &nbsp;-&nbsp;
                      <a href="{{route('frontend.airports.show', [$m->pirep->arr_airport_id])}}">{{$m->pirep->arr_airport_id}}</a>
                    </td>
                    <td>
                      {{ \App\Models\Enums\PirepStatus::label($m->pirep->status) }}
                    </td>
                  </tr>
                @endif
              @endforeach
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
