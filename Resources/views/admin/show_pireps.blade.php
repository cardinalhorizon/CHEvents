@extends('chevents::layouts.admin')

@section('title', 'CHEvents > '.$event->name.' > PIREPs')
@section('actions')
  <li>
    <a href="{{ route('admin.chevents.show', $event) }}">
      <i class="ti-pencil"></i>
      Back</a>
  </li>
@endsection
@section('content')
  <div class="card border-blue-bottom">
    <div class="content">
      <h2>PIREPs</h2>
      <form class="form-inline" method="POST" action="{{route('admin.chevents.pireps.attach', $event)}}">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-group">
          <label for="exampleInputName2">PIREP ID</label>
          <input type="text" name="pirep_id" class="form-control" id="exampleInputName2">
          <button type="submit" class="btn btn-default">Associate PIREP</button>
        </div>
      </form>
      <div class="table-responsive">
        <table class="table table-hover table-striped">
          <thead>
          <tr>
            <th>User</th>
            <th>Flight Number</th>
            <th>Departure Airport</th>
            <th>Arrival Airport</th>
            <th>Status</th>
            <th>State</th>
            <th>Actions</th>
          </tr>
          </thead>
          <tbody>
          @foreach($pireps as $pirep)
            <tr>
              <td>{{$pirep->user->name}}</td>
              <td>
                {{$pirep->ident}}
              </td>
              <td>
                {{$pirep->dpt_airport->id}} - {{$pirep->dpt_airport->name}}
              </td>
              <td>
                {{$pirep->arr_airport->id}} - {{$pirep->arr_airport->name}}
              </td>
              <td>
                {{\App\Models\Enums\PirepStatus::label($pirep->status)}}
              </td>
              <td>
                {{\App\Models\Enums\PirepState::label($pirep->state)}}
              </td>
              <td>
                <div class="btn-group-sm">
                  <a class="btn btn-info" href="{{route('admin.pireps.show', $pirep)}}">View</a>
                  <a class="btn btn-danger" href="#" onclick="event.preventDefault();
                                    document.getElementById('detach_pirep_{{ $pirep->id }}').submit();">Detach</a>
                  <form id="detach_pirep_{{ $pirep->id }}" method="POST" action="{{ route('admin.chevents.pireps.detach', [$event->id]) }}" accept-charset="UTF-8" hidden>
                    @csrf
                    {{method_field('DELETE')}}
                    <input hidden name="pirep_id" value="{{$pirep->id}}"/>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach

          </tbody>
        </table>
      </div>

    </div>
  </div>
@endsection
