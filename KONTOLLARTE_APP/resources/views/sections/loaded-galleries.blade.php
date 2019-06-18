@isset($galleriesReloadedList) 

    @foreach($galleriesReloadedList as $currentGallery)

    <div class="col-lg-6 gi-box">
        <div class="gi-box-content">

            <!-- Name -->
            <div class="gi-box-content-header">
                    {{ $currentGallery->galleryName }}
            </div>

            <!-- Gallery info -->
            <div class="gi-box-content-info">

                <p class="email-title">Email</p>
                <p class="email-content">{{ $currentGallery->galleryEmail }}</p>
                <p class="region-title">Region</p>
                <p class="region-content">{{ $currentGallery->galleryAddress }}</p>
                
                <div class="btn-container">
                    <a data-toggle="modal" href="#confirm-add-gallery" 
                        class="btn btn-dark add-btn" 
                        data-gallery-id="add/{{ $currentGallery->galleryId }}"> <!-- Route to add gallery -->
                        Add</a></br>
                    <a href="{{ $currentGallery->galleryWeb }}" class="btn btn-danger site-btn">Go to the site</a>
                </div>

            </div>

        </div>
    </div>

    @endforeach

 @endisset
        



