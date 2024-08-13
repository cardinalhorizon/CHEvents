@extends('chevents::layouts.admin')

@section('title', 'CHEvents > New Event')

@section('content')
  <div class="card border-blue-bottom">
    <div class="content">
      <form method="post" action="{{route('admin.chevents.update', $event)}}">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        <div class="row">
          <div class="form-group col-sm-3">
            <label class="form-label">Name:</label><span class="required">*</span>
            <input class="form-control" value="{{$event->name}}" name="name">
          </div>
          <div class="form-group col-sm-3">
            <label class="form-label">Start Date & Time:</label><span class="required">*</span>
            <input class="form-control flatpickr" value="{{$event->starting_at}}" name="starting_at" id="start_date" placeholder="2021-03-25 15:00">
          </div>
          <div class="form-group col-sm-3">
            <label class="form-label">End Date & Time:</label><span class="required">*</span>
            <input class="form-control flatpickr" value="{{$event->ending_at}}" name="ending_at" id="end_date" placeholder="2021-03-25 17:00">
          </div>
          <div class="form-group col-sm-3">
            <label class="form-label">Route Code:</label><span class="required">*</span>
            <input class="form-control" style="text-transform:uppercase" name="route_code" value="{{$event->route_code}}" placeholder="EVT">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-6">
            <label class="form-label">Description:</label>
            <textarea name="description" id="editor" class="editor" cols="50" rows="10">{{$event->description}}</textarea>
          </div>
          <div class="form-group col-sm-6">
            <label class="form-label">Banner Image URL:</label>
            <input class="form-control" name="banner_url" value="{{$event->banner_url}}" placeholder="https://yourlinkhere">
          </div>
        </div>
        <button class="btn btn-primary" type="submit">Submit</button>
      </form>
    </div>
  </div>
@endsection
@section('scripts')
  @parent
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="{{ public_asset('assets/vendor/ckeditor4/ckeditor.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    $(document).ready(function () {
      CKEDITOR.replace('editor');
      flatpickr('.flatpickr', {
        enableTime: true,
        dateFormat: "Y-m-d H:i"
      });
    });
  </script>
@endsection
