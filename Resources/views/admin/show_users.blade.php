@extends('chevents::layouts.admin')

@section('title', 'CHEvents > '.$event->name.' > Users')
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
      <h2>Users</h2>
      <form class="form-inline" method="POST" action="{{route('admin.chevents.users.attach', $event)}}">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-group">
          <label for="exampleInputName2">User</label>
          <select type="text" name="user_id" class="form-control select2" id="exampleInputName2">
            <option value="0">Select User</option>
            @foreach(\App\Models\User::all() as $user)
              <option value="{{$user->id}}">{{$user->ident}} | {{$user->name}}</option>
            @endforeach
          </select>
          <button type="submit" class="btn btn-default">Add User</button>
        </div>
      </form>
      <div style="background: #ccc; padding: 5px; font-size: 24px; margin: 1rem 0;">
        Current Users
      </div>
      @foreach($event->users as $user)
        <span>
          {{$user->ident}} | {{$user->name}}
          <a href="#" class="btn-sm btn-danger" onclick="event.preventDefault();
                                    document.getElementById('detach_{{$user->id}}').submit();">
      X</a>
    <form id="detach_{{$user->id}}" method="POST" action="{{ route('admin.chevents.users.detach', $event) }}" accept-charset="UTF-8" hidden>
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <input hidden name="user_id" value="{{$user->id}}"/>
    </form>
        </span>
      @endforeach
    </div>
  </div>
@endsection
