<div class="row">
  @foreach($events as $event)
    <div class="col-md-6 col-sm-12">

      <div class="card border-blue-bottom">
        <div class="card-body" style="min-height: 0">
          <div class="row">
            <div class="col-sm-9">
              <h5>
                <a class="text-c" href="{{ route('chevents.show', [$event->id]) }}">
                  {{$event->name}}
                </a>
              </h5>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-8">
              @if($event->banner_url)
                <img src="{{$event->banner_url}}" style="width: 100%" alt="{{$event->name}}"/>
              @endif
            </div>
            <div class="col-sm-4">
              @if(now() > $event->starting_at && now() < $event->ending_at)
                <h5><span class="badge badge-info">In Progress</span></h5>
              @elseif(now() > $event->ending_at)
                <h5><span class="badge badge-success">Completed</span></h5>
              @else
                <h5><span class="badge badge-warning">{{ \Carbon\Carbon::parse($event->starting_at)->diffForHumans() }}</span></h5>
              @endif
              <div>{{$event->starting_at}} - {{$event->ending_at}}</div>
              <a class="btn btn-block btn-info mt-2" href="{{ route('chevents.show', [$event->id]) }}">
                More Information
              </a>
              @if($event->can_join)
                @if(!$event->users->contains(Auth::user()->id))
                  <a class="btn btn-block btn-success mt-2" href="" onclick="event.preventDefault();
                                    document.getElementById('join{{ $event->id }}').submit();">Join</a>
                  <form id="join{{ $event->id }}" method="POST" action="{{ route('chevents.attach', [$event->id]) }}" accept-charset="UTF-8" hidden>
                    @csrf
                  </form>
                @else
                  <a class="btn btn-block btn-danger mt-2" href="" onclick="event.preventDefault();
                                    document.getElementById('leave{{ $event->id }}').submit();">Leave</a>
                  <form id="leave{{ $event->id }}" method="POST" action="{{ route('chevents.detach', [$event->id]) }}" accept-charset="UTF-8" hidden>
                    {{ method_field('DELETE') }}
                    @csrf
                  </form>
                @endif
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>
