@extends('layouts.internal-master')

@section('content')

@include('sections.messages.message-messages')

<div class="container-fluid p-5 title-container"> <!-- Title container panel -->

        <div class="col-2 col-sm-2 title-before-container">
            <p class="title-before">Connect<br>with<br>partners<br>sending</br>easy</p>
        </div>

        <div class="col-2 col-sm-2 pt-2 pb-1 mt-4 mb-4 title-main-container">
            <p class="title-main">MESSAGES</p>
        </div>

    </div> <!-- Title container panel end -->

    <div class="container-fluid pm-main-container"> <!-- Personal message container start -->

        <!-- Title -->
        <div class="col-md-4 pm-title-container"> 
                <b>Sent</b> messages
        </div>

        <!-- Messages -->
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

        <div class="container-fluid pm-items-container"> <!-- Items -->

            @if (!$userMessagesList->isEmpty())

                <!-- Hamburger header -->
                <div class="col-8 pm-dropdown d-flex justify-content-between">

                    <div class="left-dropdown-title">
                        VIEW
                    </div>
                
                    <div class="hmg-container">
                        <span>
                            <i class="fas fa-bars"></i>
                        </span>
                    </div>

                    <div class="right-dropdown-title">
                        BACK
                    </div>

                </div>

                <!-- Sent messages box -->
                <div class="col-lg-8 pm-items-box"> 

                    <!-- Header -->
                    <div class="row"> 

                        <div class="col-md-4 rh">
                            <span>Messages</span>
                        </div>

                        <div class="col-md-8 rc">
                            Content
                        </div>

                    </div>

                @php
                $index = 1;
                @endphp

                @foreach($userMessagesList as $currentMessage)

                    @foreach($currentMessage->receivers as $currentReceiver)

                        <!-- Message start -->
                        <div class="row"> 

                            <div class="col-md-4 rh-hidden">
                                Receiver
                            </div>

                            <!-- Message header -->
                            <div class="col-md-4 pm-title">
                                <span>{{ 'Message '.$index }}</span>
                                </br>
                                <span>{{ $currentReceiver->receiverName }}</span>
                            </div>

                            <div class="col-md-8 rc-hidden">
                                Content
                            </div>

                            <!-- Message info -->
                            <div class="col-md-8 pm-content">

                                <p class="pm-content-email-h">Email</p>
                                <p class="pm-content-email-c">{{ $currentReceiver->receiverEmail }}</p>

                                <p class="pm-content-date-h">Date</p>
                                <p class="pm-content-date-c">{{ $currentMessage->messageDate }}</p>

                                <p class="pm-content-text-h">Content</p>
                                <p class="pm-content-text-c">
                                    {{ $currentMessage->messageBody }}
                                </p>

                            </div>

                        </div> <!-- Message end -->

                    @endforeach

                    @php
                    $index++;
                    @endphp

                @endforeach

                </div> <!-- Items box end -->

            @else

            <!-- Not found message -->
            <div class="row flex-column">

                <!-- Svg logo container -->
                <div class="svg-container">
                    <img src="../images/binocular-purple.svg" alt="" width="200" height="200">
                </div>

                <!-- Message container -->
                <p class="not-found p-5">
                    No messages have been found on the database yet</br>
                    Send the first one now
                </p>

            </div>

            @endif

        </div>

    </div> <!-- Personal message container end -->

    <div class="container-fluid wm-main-container"> <!-- Write message main container start -->

        <!-- Title -->
        <div class="col-md-4 wm-title-container"> 
            <b>Write</b> a new message
        </div>

        <!-- Write email items -->
        <div class="container-fluid wm-items-container"> 

        <form method="get">

            <!-- Receivers checkboxes -->
            <div class="col-lg-10 wm-ch-box">

                @if ($galleriesUserList->isNotEmpty())

                    <p class="pr-title">Select your receivers</p>

                    <div class="row">

                        @foreach($galleriesUserList as $currentGallery)

                            <!-- Block of receiver -->
                            <div class="col-md-6 wm-ch-items">
                                <div class="ch-item-container">
                                {{ $currentGallery->galleryName }}</br>{{ $currentGallery->galleryEmail }}
                                    </br>

                                    <!-- Custom checkbox -->
                                    <label class="wm-lbl"
                                        for="customCheck{{ $currentGallery->galleryId }}">
                                        <input type="checkbox"
                                            id="customCheck{{ $currentGallery->galleryId }}"
                                            name="galleriesList[]" 
                                            value="{{ $currentGallery->galleryId }}"
                                            class="input-tags">
                                        <span class="checkmark"></span>
                                    </label>

                                </div>
                            </div>

                        @endforeach

                    </div>

                @else 

                <!-- Not found message -->
                <p class="not-found galleries-not-found p-5">
                    No galleries have been found on the database yet</br>
                    Let's find the best for you
                </p>

                @endif

            </div>

            <!-- Write message box -->
            <div class="col-lg-10 wm-me-box"> 

                <!-- Write message title -->
                <p class="me-title">Build your message</p> 

                <!-- Message textarea -->
                <div class="me-txt-container"> 

                    <textarea onkeydown="enableDisableSubmitButton()" 
                              rows="10" cols="100"
                              id="message-body" 
                              name="message-body"></textarea>

                    <div class="btn-container">
                        <button type="button" 
                                class="btn submit-btn">
                                Send
                        </button>
                    </div>

                </div>
                
            </div>
        
        </form>
    
        </div>

    </div> <!-- Write message main container end -->

@endsection('content')