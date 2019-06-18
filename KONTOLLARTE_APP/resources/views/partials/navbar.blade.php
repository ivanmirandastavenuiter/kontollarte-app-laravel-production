<div class="container-fluid navbar-container"> <!-- Navbar container start -->

    <div class="row navbar-row justify-content-center align-items-center"> <!-- Navbar row start -->

        <div class="col-lg-3 p-3 navbar-title"> 
            <a href="{{ route('shows.display') }}"><span class="span-lg-title">Kontollarte</span></a>
        </div>

        <div class="col-lg-9 sections-container">

            <div class="row sections-row">

                <div class="col-lg-12 mr-nav">
                    <div class="row title-section-row justify-content-end align-items-center">
                        <div class="col-lg-1">
                            <a href="{{ route('account.display') }}">Account</a>   
                            <span class="color-bar bar-one"></span> 
                        </div>
                        <div class="col-lg-1">
                            <a href="{{ route('shows.display') }}">Shows</a>
                            <span class="color-bar bar-two"></span>
                        </div>
                        <div class="col-lg-1">
                            <a href="{{ route('paintings.display') }}">Paints</a>
                            <span class="color-bar bar-three"></span>
                        </div>
                        <div class="col-lg-1">
                            <a href="{{ route('galleries.display') }}">Partners</a>
                            <span class="color-bar bar-four"></span>
                        </div>
                        
                        <div class="col-lg-1">
                            <a href="{{ route('messages.display') }}">Mails</a>
                            <span class="color-bar bar-five"></span>
                        </div>
                        <div class="col-lg-1">
                            <a href="{{ route('sales.display') }}">Market</a>
                            <span class="color-bar bar-six"></span>
                        </div>
                        <div class="col-lg-1 logout">
                            <a class="logout-link"><span>Out</span></a>
                            <form action="{{ url('/logout') }}" method="post" id="logout">@csrf</form>
                        </div>
                        <div class="col-lg-1 logout-hidden">
                            <a class="logout-link"><span>Out</span></a>
                            <span class="color-bar bar-seven"></span>
                        </div>
                    </div>
                </div>
                
            </div>
    
        </div>

    </div> <!-- Navbar row end -->

</div> <!-- Navbar container end -->