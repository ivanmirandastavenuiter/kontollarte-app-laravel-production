@extends('layouts.internal-master')

@section('content')

@include('sections.messages.account-messages')

<div class="container-fluid p-5 title-container"> <!-- Title container panel -->

    <div class="col-2 col-sm-2 title-before-container">
        <p class="title-before">Maintain<br>your<br>profile<br>updated</br>with</p>
    </div>

    <div class="col-2 col-sm-2 pt-2 pb-1 mt-4 mb-4 title-main-container">
        <p class="title-main">ACCOUNT</p>
    </div>

</div> <!-- Title container panel end -->

<!-- Title -->
<div class="col-md-4 ac-title-container"> 
    <b>My</b> personal account
</div>

<div class="container-fluid d-flex justify-content-center account-body-container"> <!-- Account body container start -->

    @isset($delete)
        @if($delete)
            <script>
                $('#delete-success').modal('show');
            </script>
        @endif
    @endisset

    @if ($errors->any())
        <script>
            $('#update-user').modal('show');
        </script>
    @endif

    <div class="col-md-9 account-box-container">

        <div class="row">

            <!-- Messages -->
            <div class="col-12 alert-container">

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

            </div>

            <!-- User account info -->
            <div class="col-md-3 p-3 account-box-left">
                <p>Username</p>
            </div>

            <div class="col-md-3 p-3 pl-5 account-box-right">
                <p>{{ $currentUser->username }}</p>
            </div>

            <div class="w-100"></div>

            <div class="col-md-3 p-3 account-box-left">
                <p>Name</p>
            </div>

            <div class="col-md-3 p-3 pl-5 account-box-right">
                <p>{{ $currentUser->name }}</p>
            </div>

            <div class="w-100"></div>

            <div class="col-md-3 p-3 account-box-left">
                <p>Surname</p>
            </div>

            <div class="col-md-3 p-3 pl-5 account-box-right">
                <p>
                    @if(empty($currentUser->surname))
                        {{ 'Not provided' }}
                    @else 
                        {{ $currentUser->surname }}
                    @endif
                </p>
            </div>

            <div class="w-100"></div>

            <div class="col-md-3 p-3 account-box-left">
                <p>Email</p>
            </div>

            <div class="col-md-3 p-3 pl-5 account-box-right">
                <p>{{ $currentUser->email }}</p>
            </div>

            <div class="w-100"></div>

            <div class="col-md-3 p-3 account-box-left">
                <p>Phone</p>
            </div>

            <div class="col-md-3 p-3 pl-5 account-box-right">
                <p>
                    @if(empty($currentUser->phone))
                        {{ 'Not provided' }}
                    @else 
                        {{ $currentUser->phone }}
                    @endif
                </p>
            </div>

            <div class="w-100"></div>

            <!-- Buttons -->

            <div class="col-md btn-container">
                <button id="first-update-button" class="btn btn-dark update-btn" data-toggle="modal" data-target="#update-user">Update user</button>
                <button id="first-delete-button" class="btn btn-danger delete-btn mt-5 ml-3 mb-5" data-toggle="modal" data-target="#confirm-delete">Delete user</button>
            </div>

        </div>

    </div>

</div> <!-- Account body container end-->

@endsection('content')