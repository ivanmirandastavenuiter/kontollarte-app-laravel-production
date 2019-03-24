@isset($view)

    @switch($view)

        @case('register')
            <link rel="stylesheet" href="{{ URL::to('css/register.css') }}" type="text/css">
            <!-- Convert to full path: {{ URL::to('css/stlyes.css') }} -->
            <title>Register</title>
            @break

        @case('login')
            <link rel="stylesheet" href="{{ URL::to('css/login.css') }}" type="text/css">
            <!-- Convert to full path: {{ URL::to('css/stlyes.css') }} -->
            <title>Login</title>
            @break

        @case('email')
            <link rel="stylesheet" href="{{ URL::to('css/email.css') }}" type="text/css">
            <!-- Convert to full path: {{ URL::to('css/stlyes.css') }} -->
            <title>Recovery email</title>
            @break

        @case('reset')
            <link rel="stylesheet" href="{{ URL::to('css/reset.css') }}" type="text/css">
            <!-- Convert to full path: {{ URL::to('css/stlyes.css') }} -->
            <title>Reset password</title>
            @break

         @case('verify')
            <link rel="stylesheet" href="{{ URL::to('css/verify.css') }}" type="text/css">
            <!-- Convert to full path: {{ URL::to('css/stlyes.css') }} -->
            <title>Reset password</title>
            @break


    @endswitch

@endisset