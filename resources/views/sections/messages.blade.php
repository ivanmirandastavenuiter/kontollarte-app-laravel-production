@extends('layouts.internal-master')

@section('content')

@include('sections.messages.message-messages')

    <div class="container-fluid main-container">

        <div class="col-12" id="message-view-title">
            <h2>Messages</h2>
        </div>

        <div class="alert-container">

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success')}}
            </div>
            @elseif (session('fail'))
            <div class="alert alert-danger">
                {{ session('fail')}}
            </div>
            @endif

        </div>

        <div class="container-fluid table-container">

            <div class="col-12" id="message-table-title">
                <h3>Messages sent</h3>
            </div>

            @if (!$userMessagesList->isEmpty())

            <table class="table table-borderless table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Content</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>

                @php
                    $index = 1;
                @endphp

                @foreach($userMessagesList as $currentMessage)

                    @foreach($currentMessage->receivers as $currentReceiver)
                
                    <tr>
                        <th scope="row">{{ $index }}</th>
                        <td>{{ $currentReceiver->receiverName }}</td>
                        <td>{{ $currentReceiver->receiverEmail }}</td>
                        <td>{{ $currentMessage->messageBody }}</td>
                        <td>{{ $currentMessage->messageDate }}</td>
                    </tr>

                    @endforeach

                    @php
                        $index++;
                    @endphp 

                @endforeach

                </tbody>
            </table>

            @else

                <div class="col-12" id="message-notfound-title">
                    <h4>No messages have been found on database yet</h4>
                </div>

            @endif
        
        </div>

        <div class="container-fluid messages-container">

        <form method="get">
            <div class="form-row">

                <div class="col col-sm-12 col-md-6 col-lg-6 left-side">

                    <div class="container-fluid message-box-container">

                        <h3>Communicate with the world and show your works!</h3>

                        <div class="form-group">
                            <label for="comment">Write a message:</label>
                            <textarea onkeydown="enableDisableSubmitButton()" class="form-control" rows="5" id="message-body" name="message-body"></textarea>
                        </div>

                        <div class="message-btn-container">
                            <button type="button" class="btn btn-danger submit-btn">Send</button>
                        </div>

                    </div>
                
                </div>

                <div class="col col-sm-12 col-md-6 col-lg-6 right-side">

                    <div class="container-fluid galleries-checkbox-container">

                        @if (!empty($galleriesUserList))

                        <h3>Check the galleries you want to contact with!</h3>

                        <div class="radio-btn-container">

                            @foreach($galleriesUserList as $currentGallery)

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" 
                                           class="custom-control-input" 
                                           id="customCheck{{ $currentGallery->galleryId }}"
                                           name="galleriesList[]" 
                                           value="{{ $currentGallery->galleryId }}">
                                    <label class="custom-control-label" 
                                           for="customCheck{{ $currentGallery->galleryId }}">
                                           {{ $currentGallery->galleryName }} - {{ $currentGallery->galleryEmail}}
                                    </label>
                                </div>

                            @endforeach

                        </div>

                        @else

                        <h3>No galleries have been found on the database yet</h3>

                        @endif

                    </div>
                
                </div>
            
            </div>

        </form>

        </div> 
    
    </div> 
    
@endsection('content')