@extends('layouts.master')

@section('content') 

<form action="{{ route('csrf.response') }}" method="post">

    <label for="id">Id</label>
    <input type="text" name="id">

    <label for="name">Name</label>
    <input type="text" name="name">
    
    <!-- This prevent from external attacks sending and checking unique token to the server -->
    {{ csrf_field() }} 
    <button type="submit" class="btn btn-primary">Submit</button>

</form>
@endsection