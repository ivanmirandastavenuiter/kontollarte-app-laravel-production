@extends('layouts.internal-master')

@section('content')

@include('sections.messages.show-messages')

<div class="container-fluid p-5 title-container"> <!-- Title container panel -->

        <div class="col-2 col-sm-2 title-before-container">
            <p class="title-before p-5">Have<br>you<br>seen<br>all<br>the</p>
        </div>

        <div class="col-2 col-sm-2 pt-2 pb-1 mt-4 mb-4 title-main-container">
            <p class="title-main">Shows</p>
        </div>

    </div> <!-- Title container panel end -->

    <div class="container-fluid shows-slider-container"> <!-- Shows slider container start -->

        <!-- Title -->
        <div class="col-md-6 sh-title-container"> 
            <b>Have</b> a look at the shows
        </div>

        <div class="row">
        
        <!-- Information div -->
            <div class="data-storage" data-position=0 data-database=true></div>

            <!-- Left margin div -->
            <div class="col-12 col-sm slider-prev"></div>

            <!-- Center main content -->
            <div class="col-12 col-sm-8 d-flex justify-content-center slider-image">
                <div class="mt-5 image-container">

                    <img
                     src="{{ $currentShow['showImgData']['link'] }}" 
                     height="{{ $currentShow['showImgData']['height'] }}" 
                     width="{{ $currentShow['showImgData']['width'] }}">

                     <div class="spinner-border text-dark" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                
                </div>
            </div>

            <!-- Right margin -->
            <div class="col-12 col-sm slider-next"></div>

        </div>

        <!-- Prev/Next controls -->
        <div class="row">

            <div class="col col-sm-6 mt-4 mb-4 d-flex justify-content-end image-prev">
                <div class="d-flex justify-content-center align-items-center prev-box-right">
                    <a class="control-prev">
                        <span><i class="fas fa-chevron-left"></i></span>
                    </a>
                </div>
            </div>
            <div class="col col-sm-6 mt-4 mb-4 d-flex justify-content-start image-next">
                <div class="d-flex justify-content-center align-items-center prev-box-left">
                    <a class="control-next">
                        <span><i class="fas fa-chevron-right"></i></span>
                    </a>
                </div>
            </div>

        </div>

    </div> <!-- Shows slider container end -->

    <div class="container-fluid shows-data-container"> <!-- Show data container start -->

        <!-- Name -->
        <div class="row"> 
            <div class="col-12 col-sm mt-4"></div>
            <div class="col-12 col-sm-8 mt-4 data-container">
                <p class="pt-4 pb-4 data-title">Name</p>
                <p class="pt-4 data-content name-paragraph">{{ $currentShow['showName'] }}</p>
            </div>
            <div class="col-12 col-sm mt-4"></div>
        </div>

        <!-- Dates -->
        <div class="row"> 
            <div class="col-12 col-sm"></div>
            <div class="col-12 col-sm-8 data-container">
                <p class="pt-4 pb-4 data-title">Date</p>
                <p class="pt-4 data-content date-paragraph">
                    <b>Starting date: </b>{{ $currentShow['showStartingDate'] }}</br>
                    <b>Starting date: </b>{{ $currentShow['showEndingDate'] }}
                </p>
            </div>
            <div class="col-12 col-sm"></div>
        </div>

        <!-- Description -->
        <div class="row"> 
            <div class="col-12 col-sm mt-4"></div>
            <div class="col-12 col-sm-8 mt-4 data-container">
                <p class="pt-4 pb-4 data-title">Description</p>
                <p class="p-4 data-content description-paragraph">{{ $currentShow['showDescription'] }}</p>
            </div>
            <div class="col-12 col-sm mt-4"></div>
        </div>


    </div> <!-- Show data container end -->

@endsection('content')