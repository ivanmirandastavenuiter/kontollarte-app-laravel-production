@extends('layouts.internal-master')

@section('content')

@include('sections.messages.gallery-messages')

<div class="result-response" data-result-response='none'></div>

    <div class="container-fluid wrapper">

        <div class="col-12" id="gallery-view-title">
            <h2>Galleries</h2>
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

            <div class="col-12" id="gallery-table-title">
                <h3>My personal galleries</h3>
            </div>

            @if(count($galleriesUserList) > 0)

            <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Region</th>
                <th scope="col">Site</th>
                <th scope="col">Email</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

                @php
                    $position = 1;
                @endphp
                
                
                @foreach($galleriesUserList as $currentGallery)

                    <tr>
                    <th scope="row">{{ $position }}</th>
                    <td>{{ $currentGallery->galleryName }}</td>
                    <td>{{ $currentGallery->galleryAddress }}</td>
                    <td>{{ $currentGallery->galleryEmail }}</td>
                    <td>{{ $currentGallery->galleryWeb }}</td>
                    <td><a class="btn btn-danger dlt-btn" 
                                data-delete-id="delete/{{ $currentGallery->galleryId }} "
                                data-toggle="modal" href="">
                                Delete</a></td>
                    </tr>

                    @php
                        $position++;
                    @endphp

                @endforeach

            </tbody>
            </table>

            @else

            <div class="col-12" id="gallery-notfound-title">
                <h4>No galleries have been found on the database yet</h4>
            </div>

            @endif

        </div>

        <div class="container-fluid cards-container">

            <div class="col-12" id="gallery-table-title">
                <h3>Galleries catalogue</h3>
            </div>

            <div class="row">

            @foreach($galleriesPageList as $currentKey => $currentGallery)

                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 left">
                
                    <div class="card text-center">
                        <div class="card-header">
                            Info
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $currentGallery->galleryName }}</h5>
                            <p class="card-text">{{ $currentGallery->galleryEmail }}</p>
                            <p class="card-text">{{ $currentGallery->galleryAddress }}</p>
                            <a data-toggle="modal" href="#confirm-add-gallery" 
                                    class="btn btn-warning add-btn" 
                                    data-gallery-id="add/{{ $currentGallery->galleryId }}"> <!-- Route to add gallery -->
                                    Add gallery</a>
                            <a href="{{ $currentGallery->galleryWeb }}" class="btn btn-danger">Go to the site</a>
                        </div>
                        <div class="card-footer text-muted">
                            Kontollarte
                        </div>
                    </div>

                </div>

                @if ($currentKey % 2 != 0) 
                    </div>
                    <div class='row'>
                @endif
                        
            @endforeach

            </div> 

        </div>

        <div class="refresh-btn-container">
            <button type="button" class="btn btn-secondary refresh-galleries-btn">I want more!!!</button>
        </div>

    </div> 

@endsection('content')