@extends('layouts.internal-master')

@section('content')

@include('sections.messages.show-messages')

<div class="container-fluid main-container">

    <div class="col-12" id="show-view-title">
        <h2>Shows</h2>
        <h3>Check out the latest shows upcoming!</h3>
    </div>

    <div class="slider-container" data-position=0 data-database=true>

    <div class="gif-container">
    <h3>Loading...</h3>
        <div class="gif"></div>
    </div>

        <div id="carouselExampleControls" class="carousel slide" data-interval="false">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" 
                     src="{{ $currentShow['showImgData']['link'] }}" 
                     height="{{ $currentShow['showImgData']['height'] }}" 
                     width="{{ $currentShow['showImgData']['width'] }}" 
                     alt="Slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        </div>

    </div>

    <div class="container-fluid info-container">
        <div class="info-content-container">
            <div class="row info-row">

                <div class="col info-column">

                    <div class="card-container">
                        <div class="card-top">
                            <div class="icon-container">
                                <i class="fas fa-pencil-alt"></i>
                            </div>
                            <h3>Name</h3>
                        </div>
                        <div class="card-bottom">
                                <p class="name-paragraph">{{ $currentShow['showName'] }}</p>
                        </div>
                    </div>

                </div>

                <div class="col info-column">

                    <div class="card-container">
                            <div class="card-top">
                                <div class="icon-container">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <h3>Dates</h3>
                            </div>
                            <div class="card-bottom">
                            <p class="date-paragraph">
                                <b>Starting date: </b>{{ $currentShow['showStartingDate'] }}</br>
                                <b>Starting date: </b>{{ $currentShow['showEndingDate'] }}
                            </p>
                            </div>
                    </div>

                </div>

                <div class="col info-column">

                <div class="card-container">
                        <div class="card-top">
                            <div class="icon-container">
                            <i class="fas fa-eye"></i>
                            </div>
                            <h3>Description</h3>
                        </div>
                        <div class="card-bottom">
                        <p class="description-paragraph">{{ $currentShow['showDescription'] }}</p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div> 
</div> 
@endsection('content')