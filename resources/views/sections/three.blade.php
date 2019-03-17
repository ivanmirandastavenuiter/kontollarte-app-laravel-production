@extends('layouts.master')

@section('content')

<h1>You have been relocated to page three.</h1>
<a href="{{ route('sections.welcome') }}" role="button" class="btn btn-warning">Back</a>

@endsection