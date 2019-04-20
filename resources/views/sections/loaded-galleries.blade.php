@isset($galleriesReloadedList) 

    <!-- Row -->
    <div class="row">

        @foreach($galleriesReloadedList as $key => $currentGallery)

            <!-- Flex container -->
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 left">
            
                <!-- Card -->
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
                                data-gallery-id="add/{{ $currentGallery->galleryId }}">
                                Add gallery</a>
                        <a href="{{ $currentGallery->galleryWeb }}" class="btn btn-danger">Go to the site</a>
                    </div>
                    <div class="card-footer text-muted">
                        Kontollarte
                    </div>
                </div>

            </div> 

            @if ($key % 2 != 0) 
                </div>
                <div class='row'>
            @endif

        @endforeach

 @endisset
        
</div> <!-- Row end -->



