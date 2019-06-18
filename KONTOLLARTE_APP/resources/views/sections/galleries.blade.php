@extends('layouts.internal-master')

@section('content')

@include('sections.messages.gallery-messages')

<div class="container-fluid p-5 title-container"> <!-- Title container panel -->

        <div class="col-2 col-sm-2 title-before-container">
            <p class="title-before">Go<br>deep<br>into<br>hundreds</br>of</p>
        </div>

        <div class="col-2 col-sm-2 pt-2 pb-1 mt-4 mb-4 title-main-container">
            <p class="title-main">GALLERIES</p>
        </div>

    </div> <!-- Title container panel end -->

    <div class="container-fluid pg-container"> <!-- Personal galleries container start -->

        <!-- Title -->
        <div class="col-md-4 pg-title-container">
           <b>My</b> personal galleries
        </div>

        <!-- Errors -->
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

        <!-- Personal user galleries -->
        <div class="col-md pg-table-container">

            @if(count($galleriesUserList) > 0)

                @php
                    $position = 1;
                @endphp
                    
                @foreach($galleriesUserList as $currentGallery)

                    <!-- Item main container -->
                    <div class="table-item-main-container d-flex"> 

                        <!-- Gallery info -->
                        <p class="item-index"> 
                            {{ $position }}<span>________</span> 
                        </p>
                        <p class="item-content">
                            {{ $currentGallery->galleryName }}
                            <span class="sp-plus sp-plus-{{ $currentGallery->galleryId }}"
                                value="{{ $currentGallery->galleryId }}">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="sp-minus sp-minus-{{ $currentGallery->galleryId }}"
                                value="{{ $currentGallery->galleryId }}">
                                <i class="fas fa-minus"></i>
                            </span> 
                        </p>

                    </div>

                    <!-- Item secondary container -->
                    <div class="table-item-secondary-container secondary-container-{{ $currentGallery->galleryId }}"> 

                        <p class="item-details">
                            {{ $currentGallery->galleryEmail }}   |   {{ $currentGallery->galleryAddress }}   |   {{ $currentGallery->galleryWeb }}
                        </p>

                        <a class="btn btn-dark dlt-btn" 
                                        data-delete-id="delete/{{ $currentGallery->galleryId }}"
                                        data-toggle="modal" href="">
                                        Delete</a>

                    </div>

                @php
                    $position++;
                @endphp

                @endforeach

            @else

            <!-- Not found message -->
            <div class="row flex-column">

                <!-- Svg logo container -->
                <div class="svg-container">
                    <img src="../images/binocular-purple.svg" alt="" width="200" height="200">
                </div>

                <!-- Message container -->
                <p class="not-found p-5">
                    No galleries have been found on the database yet</br>
                    Let's find the best for you
                </p>

            </div>

            @endif

        </div>
    </div> <!-- Personal galleries container end -->

    <div class="container-fluid ng-container"> <!-- Browse new galleries container start -->

        <!-- New galleries title -->
        <div class="col-md-4 ng-title-container"> 
            <b>Find</b> new galleries
        </div>
 
        <!-- Gallery info container -->
        <div class="col-md gi-container"> 

            <div class="row main-row">

                @foreach($galleriesPageList as $currentGallery)

                <div class="col-lg-6 gi-box"> 
                    <div class="gi-box-content">

                        <!-- Name -->
                        <div class="gi-box-content-header">
                                {{ $currentGallery->galleryName }}
                        </div>

                        <!-- Details -->
                        <div class="gi-box-content-info">

                            <p class="email-title">Email</p>
                            <p class="email-content">{{ $currentGallery->galleryEmail }}</p>
                            <p class="region-title">Region</p>
                            <p class="region-content">{{ $currentGallery->galleryAddress }}</p>
                            
                            <!-- Buttons -->
                            <div class="btn-container">
                                <a data-toggle="modal" href="#confirm-add-gallery" 
                                    class="btn btn-dark add-btn" 
                                    data-gallery-id="add/{{ $currentGallery->galleryId }}"> <!-- Route to add gallery -->
                                    Add</a></br>
                                <a href="{{ $currentGallery->galleryWeb }}" class="btn btn-danger site-btn" target="_blank">Go to the site</a>
                            </div>

                        </div>

                    </div>
                </div>

                @endforeach

            </div>

            <!-- Load more button -->
            <div class="row last-row">
                <div class="col-lg-6 gi-box">
                    <div class="gi-box-content load-more-container">
                        <div class="load-more-second-container">
                            <p class="load-more-paragraph">Load more</p>
                            <button class="btn btn-dark lm-btn refresh-galleries-btn">Load more</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 gi-box"></div>
            </div>

        </div>
    </div> <!-- Browse new galleries container start -->

@endsection('content')