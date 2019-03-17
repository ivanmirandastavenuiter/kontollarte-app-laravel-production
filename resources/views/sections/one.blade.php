@extends('layouts.master')

@section('content')

<!--
|--------------------------------------------------------------------------
| Passing parameters on view method
|--------------------------------------------------------------------------
|
|     {{ route('sections.welcome', ['id' => 1]) }}
|
|     This id parameter has to be equal to the one found on route/web.php
|     This allows you to pass parameters to the view
|
-->

<h1>You have been relocated to page one.</h1>
<a href="{{ route('sections.welcome') }}" role="button" class="btn btn-warning">Back</a>

@endsection