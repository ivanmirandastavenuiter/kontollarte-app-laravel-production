@php
    $counter = 1;
@endphp

    @foreach($paintings as $paint)

        <div class="col-md-6 painting-box paint-box-{{ $paint->paintId }}">
            
            <!-- Image box -->
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

<script>
    catchDataOnUpdateClick();
    catchDataOnDeleteClick();
</script>
