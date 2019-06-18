@extends('layouts.master')

@section('content')
<!-- Main container -->
<div class="container-fluid main">

<div class="row">
<!-- Login form container -->

    <!-- Margins -->
    <div class="col-lg-1 margin-right"></div>

    <!-- La sintaxis de bootstrap es ascendente. Es decir, inlcuye todas las categorías superiores a la actual. -->
    <div class="col-lg-4 form-container">

        <div class="title text-center">Kontollarte</div>

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

                <div class="input-container">
                    <input type="text" 
                           name="email"
                           id="email"
                           class="input-box {{ $errors->has('email') ? ' is-invalid' : '' }}" 
                           value="{{ old('email') }}"
                           autofocus>
                    <span class="input-span" data-placeholder="Email"></span>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            {{ $errors->first('email') }}
                            <span class="cross-icon"><i class="fas fa-times"></i></span>
                        </span>
                    @endif
                    
                </div>

                <div class="input-container">
                        <input type="password" 
                               name="password"
                               id="password"
                               class="input-box {{ $errors->has('password') ? ' is-invalid' : '' }}">
                        <span class="input-span" data-placeholder="Password"></span>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                {{ $errors->first('password') }}
                                <span class="cross-icon"><i class="fas fa-times"></i></span>
                            </span>
                        @endif

                </div>

                <div class="form-btn-container-first">
                    <div class="form-btn-container-second">
                        <div class="form-btn-container-third"></div>
                        <button class="form-login-btn" type="submit">
                            Login
                        </button>
                    </div>
                </div>

                <div class="signup-container">
                    <span class="signup-sp">Don't you have an account?</span>
                    <a class="signup-a" href="{{ route('register') }}">Sign up</a>
                </div>

        </form>

    </div>

    <!-- Margins -->
    <div class="col-md-7 margin-right"></div>

</div>

</div> <!-- Main container end -->
<script>


(function ($) {
"use strict";

$(document).ready(function() {
    $('html, body').animate({scrollTop: 100}, {duration: 2500, easing: 'swing'});
})


/*==================================================================
[ Focus input ]*/
$('.input-box').each(function(){
    
    if($(this).val().trim() != "") {
        $(this).addClass('has-val');
    }
    else {
        $(this).removeClass('has-val');
    }

$(this).on('blur', function(){
    if($(this).val().trim() != "") {
        $(this).addClass('has-val');
    }
    else {
        $(this).removeClass('has-val');
    }
})    
})

/*==================================================================
[ Show pass ]*/
var showPass = 0;
$('.btn-show-pass').on('click', function(){
if(showPass == 0) {
    $(this).next('input').attr('type','text');
    $(this).find('i').removeClass('zmdi-eye');
    $(this).find('i').addClass('zmdi-eye-off');
    showPass = 1;
}
else {
    $(this).next('input').attr('type','password');
    $(this).find('i').addClass('zmdi-eye');
    $(this).find('i').removeClass('zmdi-eye-off');
    showPass = 0;
}

});


})(jQuery);
</script>
@endsection('content')
