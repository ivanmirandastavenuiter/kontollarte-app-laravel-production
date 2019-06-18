@extends('layouts.master')

@section('content')

 <!-- Main container -->
    <div class="container-fluid main">

        <div class="row">
        <!-- Login form container -->

            <!-- Margins -->
            <div class="col-lg-5 margin-right"></div>

            <!-- La sintaxis de bootstrap es ascendente. Es decir, inlcuye todas las categorías superiores a la actual. -->
            <div class="col-lg-5 form-container">

                <div class="title text-center">Register</div>

                <form method="POST" action="{{ route('register') }}" class="login-form">
                    @csrf
                        <div class="input-container">
                            <input class="input-box{{ $errors->has('username') ? ' is-invalid' : '' }}" 
                                   type="text" 
                                   name="username"
                                   id="username"
                                   value="{{ old('username') }}" autofocus>
                            <span class="input-span" data-placeholder="Username"></span>

                            @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                {{ $errors->first('username') }}
                                <span class="cross-icon"><i class="fas fa-times"></i></span>
                            </span>
                            @endif

                        </div>

                        <div class="input-container">
                            <input class="input-box{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                   type="text" 
                                   name="name"
                                   id="name"
                                   value="{{ old('name') }}" autofocus>
                            <span class="input-span" data-placeholder="Name"></span>

                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                {{ $errors->first('name') }}
                                <span class="cross-icon"><i class="fas fa-times"></i></span>
                            </span>
                            @endif

                        </div>

                        

                        <div class="input-container">
                            <input class="input-box{{ $errors->has('surname') ? ' is-invalid' : '' }}" 
                                   type="text" 
                                   name="surname"
                                   id="surname"
                                   value="{{ old('surname') }}" autofocus>
                            <span class="input-span" data-placeholder="Surname"></span>

                            
                            @if ($errors->has('surname'))
                            <span class="invalid-feedback" role="alert">
                                {{ $errors->first('surname') }}
                                <span class="cross-icon"><i class="fas fa-times"></i></span>
                            </span>
                            @endif
                        </div>


                        <div class="input-container">
                            <input class="input-box{{ $errors->has('email') ? ' is-invalid' : '' }}" 
                                   name="email"
                                   id="email"
                                   value="{{ old('email') }}">
                            <span class="input-span" data-placeholder="Email"></span>

                            @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            {{ $errors->first('email') }}
                            <span class="cross-icon"><i class="fas fa-times"></i></span>
                        </span>
                        @endif

                        </div>



                        <div class="input-container">
                            <input class="input-box{{ $errors->has('phone') ? ' is-invalid' : '' }}" 
                                   name="phone"
                                   id="phone"
                                   value="{{ old('phone') }}">
                            <span class="input-span" data-placeholder="Phone"></span>

                            @if ($errors->has('phone'))
                        <span class="invalid-feedback" role="alert">
                            {{ $errors->first('phone') }}
                            <span class="cross-icon"><i class="fas fa-times"></i></span>
                        </span>
                        @endif

                        </div>



                        <div class="input-container">
                                <input class="input-box{{ $errors->has('password') ? ' is-invalid' : '' }}" 
                                       type="password" 
                                       name="password"
                                       id="password">
                                <span class="input-span" data-placeholder="Password"></span>

                                @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            {{ $errors->first('password') }}
                            <span class="cross-icon"><i class="fas fa-times"></i></span>
                        </span>
                        @endif

                        </div>



                        <div class="input-container">
                            <input class="input-box" 
                                   type="password" 
                                   name="password_confirmation"
                                   id="password-confirm">
                            <span class="input-span" data-placeholder="Confirm password"></span>
                        </div>

                        <div class="form-btn-container-first">
                            <div class="form-btn-container-second">
                                <div class="form-btn-container-third"></div>
                                <button class="form-login-btn">
                                    Submit
                                </button>
                            </div>
                        </div>

                        <div class="signup-container">
                            <a class="signup-a" href="{{ route('login') }}">Back to login</a>
                        </div>

                </form>

            </div>

            <!-- Margins -->
            <div class="col-lg-2 margin-right"></div>

            

        </div>

    </div>
    <script>
    
    
(function ($) {
    "use strict";

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

@endsection