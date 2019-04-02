@extends('layouts.master')

@section('content')

    <h1>Welcome to Kontollarte App Page!</h1>
    <a href="{{ route('sections.one') }}" role="button" class="btn btn-warning">Go to one</a>
    <a href="{{ route('sections.two') }}" role="button" class="btn btn-warning">Go to two</a>
    <a href="{{ route('sections.three') }}" role="button" class="btn btn-warning">Go to three</a>
    <a href="{{ route('csrf.form') }}" role="button" class="btn btn-warning">Fill form</a>

    @if($dummyInfo)
    <div>
        {{ $dummyInfo }}
    </div>
    @endif
   

    @if(count($errors->all()))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error) 
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    @if(Session::has('info'))
        <h3>User added: </h3>
        <p>Id: {{ Session::get('info')['id'] }} </p>
        <p>Name: {{ Session::get('info')['name'] }} </p>
    @endif

@endsection