@extends('layouts.internal-master')

@section('content')

@include('sections.messages.account-messages')
<div class="row">
    <div class="col-12" id="user-info-item">
        <h2>User Info</h2>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div id="table-info-item">
        
        @if ($errors->any())
        <script>
            $('#update-user').modal('show');
        </script>
        @endif
        
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="labels">
                            Alias: {{ $currentUser->username }}
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="labels">
                            Name: {{ $currentUser->name }}
                        </div>
                    </div>
                </li>
                    <li class="list-group-item">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="labels">
                            Surname: 
                            
                            @if(empty($currentUser->surname))

                                {{ 'Not provided' }}

                            @else 

                                {{ $currentUser->surname }}

                            @endif

                        </div>
                    </div>
                </li>
                    <li class="list-group-item">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="labels">
                            Email: {{ $currentUser->email }}
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="labels">
                            Phone: 

                            @if(empty($currentUser->phone))

                                {{ 'Not provided' }}

                            @else 

                                {{ $currentUser->phone }}

                            @endif

                        </div>
                    </div>
                </li>  					
            </ul>
            <div class="d-flex justify-content-center align-items-center">
                <button id="first-update-button" type="button" class="btn btn-warning" data-toggle="modal" data-target="#update-user">Update user</button>
                <button id="first-delete-button" type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm-delete">Delete account</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>


@endsection('content')