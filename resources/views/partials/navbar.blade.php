<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ route('shows.display') }}">Kontollarte</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('account.display') }}">Account</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">Paintings</a> 
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">Galleries</a> 
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">Messages</a> 
            </li>
        </ul>
    </div>
    <ul class="navbar-nav mr-auto" id="log-out-item">
        <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Log out
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item">Close session</a>
                <form action="{{ url('/logout') }}" method="post" id="logout">@csrf</form>
            </div>
        </li>
    </ul>
</nav>

<script>

    $(document).ready(function() {
        $('a.dropdown-item').click(function(e) {
            console.log('inside fucking')
            e.preventDefault
            $('#logout').submit()
        })
    })

</script>