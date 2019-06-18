@extends('layouts.internal-master')

@section('content')

<div class="container-fluid p-5 title-container"> <!-- Title container panel -->

    <div class="col-2 col-sm-2 title-before-container">
        <p class="title-before p-5">Show<br>the<br>world<br>your<br>best</p>
    </div>

    <div class="col-2 col-sm-2 pt-2 pb-1 mt-4 mb-4 title-main-container">
        <p class="title-main">PAINTINGS</p>
    </div>

</div> <!-- Title container panel end -->

<!-- Title -->
<div class="col-md-6 sl-title-container">
    <p>Publish your jobs in the market</p>
</div>

    <!-- Data storage div -->
    @if (session('formId'))
        <div class="form-div-value" value="{{ session('formId') }}"></div>
    @endif
    
    <!-- Sale status container -->
    <div class="col-12 sales-status-container">

        <!-- Messages -->
        <div class="alert-container">

            @if (session('uploadSuccess'))
                <div class="alert alert-success">
                    {{ session('uploadSuccess')}}
                </div>
            @elseif (session('uploadFailed'))
                <div class="alert alert-danger">
                    {{ session('uploadFailed')}}
                </div>
            @endif

        </div>

        <!-- If there is any job -->
        @if(!$paintingsList->isEmpty())

            @foreach($paintingsList as $currentPaint)

                <!-- Paint container -->
                <div class="row paint-row justify-content-center"> 

                    <!-- If job is not sold -->
                    @if(!$currentPaint->sold)

                        <!-- Info paint bar -->
                        <div class="col-md-9 left-box">
                            <div class="paint-name">
                                {{ $currentPaint->paintName }}
                            </div>
                            <div class="loading-container">
                                <p class="loading-paragraph">Loading...</p>
                            </div>
                        </div>
                        
                        <!-- Cross icon -->
                        <div class="col-md-1 right-box d-flex justify-content-center align-items-center">
                            <div class="icon-cross-box">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>

                        <!-- Form container -->
                        <div class="col-md-10 form-container"> 

                            <!-- Dropdown form -->
                            <p>Display form</p>
                            <span class="display-form" token="{{ $currentPaint->paintId }}">
                                <i class="fas fa-caret-down"></i>
                            </span>

                            <!-- Form content container -->
                            <div class="form-content-container">

                                <!-- Form -->
                                <form method="post" action="{{ route('sales.upload') }}" id="selling-form-{{ $currentPaint->paintId }}" class="selling-form">
                                    @csrf

                                    <!-- Title -->
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" 
                                            class="input-box {{ $errors->has('title') ? ' is-invalid' : '' }}" 
                                            id="title"
                                            name="title">

                                            @if (session('formId'))
                                                @if ($currentPaint->paintId == session('formId'))                                                
                                                    @if ($errors->has('title'))
                                                        <span class="invalid-feedback title-invalid" role="alert">
                                                            {{ $errors->first('title') }}
                                                            <span class="cross-icon"><i class="fas fa-times"></i></span>
                                                        </span>
                                                    @endif
                                                @endif
                                            @endif
                                    </div>

                                    <!-- Price -->
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="text" 
                                            class="input-box {{ $errors->has('price') ? ' is-invalid' : '' }}" 
                                            id="price"
                                            name="price">

                                            @if (session('formId'))
                                                @if ($currentPaint->paintId == session('formId'))
                                                    @if ($errors->has('price'))
                                                        <span class="invalid-feedback price-invalid" role="alert">
                                                            {{ $errors->first('price') }}
                                                            <span class="cross-icon"><i class="fas fa-times"></i></span>
                                                        </span>
                                                    @endif
                                                @endif
                                            @endif
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea type="text"
                                                class="input-box {{ $errors->has('description') ? ' is-invalid' : '' }}" 
                                                id="description"
                                                name="description" 
                                                rows=5></textarea>

                                                @if (session('formId'))
                                                    @if ($currentPaint->paintId == session('formId'))
                                                        @if ($errors->has('description'))
                                                            <span class="invalid-feedback description-invalid" role="alert">
                                                                {{ $errors->first('description') }}
                                                                <span class="cross-icon"><i class="fas fa-times"></i></span>
                                                            </span>
                                                        @endif
                                                    @endif
                                                @endif
                                    </div>

                                    <!-- Buttons -->
                                    <div class="btn-container">
                                        <input type="hidden" name="paintId" value="{{ $currentPaint->paintId }}">
                                        <input type="hidden" name="currentPath" class="current-path" value="">
                                        <button 
                                            class="btn btn-dark submit-btn"
                                            type="submit">
                                            Submit
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div> <!-- end of form container -->

                    @else

                        <!-- If it is already sold -->
                        <div class="col-md-10 sold-box">
                            <div class="paint-name d-flex justify-content-between align-items-center">

                                {{ $currentPaint->paintName }}

                                <div class="listed">
                                    {{ 'Listed' }}
                                </div>
                                
                                <div class="icon-cross-box">
                                    <i class="fas fa-check"></i>
                                </div>

                            </div>
                        </div>

                        <!-- Ebay sold item link -->
                        <div class="col-md-10 sold-link-container"> 
                            <a class="sale-url" 
                            href="{{ $currentPaint->sale->saleUrl }}" 
                            target="_blank">
                                Visit your job on Ebay
                            </a>
                        </div>
                            
                    @endif

                </div> <!-- End of container -->

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
                    No sales made yet!</br>
                    Start earning some money now!
                </p>

            </div>

        @endif

    </div> <!-- End of sale status container -->

@endsection('content')