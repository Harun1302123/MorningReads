@extends('public_home.front')

@include('public_home.login_css')

@section('body')
    <div class="login-details my-5 container">
        
        <div id="form">
            <div id="title">
                <h2>Login</h2>
            </div>

            

            <div class="form-group clearfix">
                <div class="input-padding">
                    <label class="text-danger error-msg"></label>
                </div>
                <label for="email">Email</label>
                <input type="email" class="input-md required" id="email" name="email"
                       placeholder="User Email"><br>
                <label for="password">Password</label>
                <input type="password" class="input-md required" id="password" name="password"
                       placeholder="User Password">
                <i class="fa fa-eye-slash toggle-password-icon" aria-hidden="true"></i>
                <p></p>

                <div class="input-padding" id="captchaDiv" style="display: none;">
                    {!! NoCaptcha::renderJs() !!}
                    {!! NoCaptcha::display() !!}
                </div>

                <div id="login">
                    <button type="submit" id="btnSignIn"
                            onclick="checkUserInformation('loginForm')">Sign In
                    </button>
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <a class="black-color fs-18" href="{{ url('forget-password') }}">Forgot password ?</a>
                    </div>
                </div>
           {{--     <div class="d-flex justify-content-between float-right">
                    <div>
                        <a class="black-color fs-18" href="{{ url('/articles/support') }}">Need help? Contact
                            us</a>

                    </div>
                </div>--}}



            </div>


            @php
                $redirect_url = CommonFunction::getOssPidRedirectUrl();
            @endphp

            <div id="login">
                {{-- <button>Log In</button> --}}
                <p>------------ Or ------------</p>
                <button id="email_login"><a href="{{ route('login') }}">Login with Mobile</a></button>
                <p>Don't have an account? <a href="{{ route('signup') }}">SignUp</a></p>
                <p><a href="{{ $redirect_url }}">OSSP Login</a></p>
                <p><a href="/">Back to Home</a></p>
            </div>

        </div>
    </div>
@endsection

@include('public_home.login_js')