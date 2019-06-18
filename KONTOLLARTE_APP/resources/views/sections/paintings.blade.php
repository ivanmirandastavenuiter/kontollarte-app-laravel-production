@extends('layouts.internal-master')

@section('content')

@include('sections.messages.paintings-messages')

<div class="container-fluid p-5 title-container"> <!-- Title container panel -->

    <div class="col-2 col-sm-2 title-before-container">
        <p class="title-before p-5">Show<br>the<br>world<br>your<br>best</p>
    </div>

    <div class="col-2 col-sm-2 pt-2 pb-1 mt-4 mb-4 title-main-container">
        <p class="title-main">PAINTINGS</p>
    </div>

</div> <!-- Title panel container end -->

<div class="container-fluid paintings-items-container" data-page="0" data-loaded-images="0" data-total-images="0"> <!-- Painting items container start -->

    <!-- Title -->
    <div class="col-md-12 pt-title-container"> 
        <b>My</b> best paintings
    </div>

    <!-- Upload paint -->
    <div class="row">
        <div class="col-12 btn-upload-container">
                <p>Do you have something new?</p>
                <button class="btn btn-dark update-btn" id="btn-upload" data-toggle="modal" data-target="#upload-paint">Upload new job</button>
        </div>
    </div>

    <!-- Messages -->
    <div class="upload-success">

        @if (session('uploadSuccess'))
            <div class="alert alert-success">
                {{ 'Image has been successfully uploaded' }}
            </div>
        @elseif (session('updateSuccess'))
            <div class="alert alert-success">
                {{ 'Image has been successfully updated' }}
            </div>
        @elseif (session('deleteSuccess'))
        <div class="alert alert-success">
            {{ 'Paint has been successfully deleted' }}
        </div>
        @endif

    </div>

    @if($errors->hasBag('uploadError'))
        <script>
            $('#upload-paint').modal('show');
        </script>
    @endif

    @if($errors->hasBag('updateError'))
        <script>
            $('#update-paint').modal('show');
        </script>
    @endif

    @isset($customPaintings)
    <script>
        $('.paintings-items-container').attr('data-total-images', {{ $customPaintings}} )
    </script>
    @endisset

    @if(count($paintings) > 0)

    @php
    $counter = 1;
    @endphp

        <div class="row wrapper-row">

            @foreach($paintings as $paint)

                <!-- Paint box -->
                <div class="col-md-6 painting-box paint-box-{{ $paint->paintId }}">
                    
                    <!-- Image -->
                    <div class="image-box first">
                        <img src="{{ URL::to($paint->paintImage) }}" height="400" width="100%">
                    </div>
                    
                    <!-- Paint info container -->
                    <div class="paint-data-container"> 

                        <p class="title-header">Title</p>
                        <p class="title-content">{{ $paint->paintName }}</p>

                        <p class="date-header">Date</p>
                        <p class="date-content">{{ $paint->paintDate }}</p>

                        <p class="description-header">Description</p>
                        <p class="description-content">{{ $paint->paintDescription }}</p>

                    </div>

                    <!-- Buttons -->
                    <div class="buttons-container">
                        <button class="btn btn-dark update-btn update-btn-modify"  
                                value="{{ $paint->paintId }}" 
                                data-toggle="modal" 
                                data-target="#update-paint">
                                Update
                        </button>
                        <button class="btn btn-danger delete-btn"
                                value="{{ $paint->paintId }}" 
                                data-toggle="modal" 
                                data-target="#confirm-delete">
                                Delete
                        </button>
                    </div>

                </div>

                @php 
                if ($counter % 2 == 0) {
                @endphp
                    <div class="w-100"></div>
                @php
                } 
                $counter++;
                @endphp

            @endforeach

        </div> <!-- End of wrapper row -->

        <!-- Load more jobs -->
        <div class="row">
            <div id="btn-container" class="col-12 p-5">
                <p>Load more jobs</p>
                <button id="btn-load" onclick="loadPaints(this.value)" value="{{ $currentUser->userId }}" type="button" class="btn btn-dark btn-lg btn-block">Load More</button>
            </div>
        </div>

    @else  
            
        <!-- Not found message -->
        <div class="row flex-column">

            <!-- Svg logo container -->
            <div class="svg-container">
                <img src="../images/binocular-white.svg" alt="" width="200" height="200">
            </div>

            <!-- Message container -->
            <p class="not-found p-5">
                No painitings have been found on the database yet</br>
                Let's gonna change that
            </p>

        </div>

    @endif

</div> <!-- Painting items container end -->
@endsection('content')