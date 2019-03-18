@extends('layouts.master')

@section('content') 
<div class="container-fluid">

    <h1>CSRF Response reached successfully</h1>
    <p>Press back to go to main section</p>
    <a href="{{ route('sections.welcome')}}" class="btn btn-danger">Go to main page</a>

    <h2>User input</h2>
    <ul>
        <li>Id: {{ $info['id'] }}</li>
        <li>Name: {{ $info['name'] }}</li>
    </ul>
</div>
@endsection