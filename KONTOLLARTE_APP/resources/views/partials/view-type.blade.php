@isset($view)

    @switch($view)

        @case('register')
            <link rel="stylesheet" href="{{ URL::to('css/register.css') }}" type="text/css">
            <title>Register</title>
            @break

        @case('login')
            <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="{{ URL::to('css/login.css') }}" type="text/css">
            <title>Login</title>
            @break

        @case('show')
	        <link rel="stylesheet" href="{{ URL::to('css/shows.css') }}" class="css">
            <script type="text/javascript" src="{{ URL::to('js/shows-script.js') }}"></script>
            <title>Shows</title>
            @break

        @case('account')
	        <link rel="stylesheet" href="{{ URL::to('css/account.css') }}" class="css">
            <title>Account</title>
            @break

        @case('paintings')
	        <link rel="stylesheet" href="{{ URL::to('css/paints.css') }}" class="css">
            <script type="text/javascript" src="{{ URL::to('js/paintings-script.js') }}"></script>
            <title>Paintings</title>
            @break
        
        @case('galleries')
	        <link rel="stylesheet" href="{{ URL::to('css/galleries.css') }}" class="css">
            <script type="text/javascript" src="{{ URL::to('js/galleries-script.js') }}"></script>
            <title>Galleries</title>
            @break

        @case('messages')
	        <link rel="stylesheet" href="{{ URL::to('css/messages.css') }}" class="css">
            <script type="text/javascript" src="{{ URL::to('js/messages-script.js') }}"></script>
            <title>Messages</title>
            @break

        @case('sales')
            <link rel="stylesheet" href="{{ URL::to('css/sales.css') }}" class="css">
            <script type="text/javascript" src="{{ URL::to('js/sales-script.js') }}"></script>
            <title>Sales</title>
            @break

    @endswitch

@endisset