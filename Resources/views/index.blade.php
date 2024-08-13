@extends('chevents::layouts.frontend')

@section('title', 'CHEvents')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {{ config('chevents.name') }}
    </p>
@endsection
