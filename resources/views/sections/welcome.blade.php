@extends('layouts.master')

@section('content')

    <h1>Welcome to Kontollarte App Page!</h1>
    <a href="{{ route('sections.one') }}" role="button" class="btn btn-warning">Go to one</a>
    <a href="{{ route('sections.two') }}" role="button" class="btn btn-warning">Go to two</a>
    <a href="{{ route('sections.three') }}" role="button" class="btn btn-warning">Go to three</a>

@endsection