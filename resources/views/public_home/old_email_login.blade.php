@extends('public_home.front')
@section('body')
    <div class="login-details my-5 container">
        {{-- <div id="logo" class="d-flex justify-content-center mb-3">
            <img src="{{ asset('assets/images/logo-npo.jpg') }}" alt="Logo"> <br>
            <span>National Productivity Organization</span>
        </div> --}}
        <div id="form">
            <div id="title">
                <h2>Login</h2>
            </div>

            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Enter Your email">

            <label for="email">Password</label>
            <input type="password" id="password" placeholder="Enter Your password"> <br>
            <a href="#">Forgot Password?</a>

            <div id="login">
                <button>Log In</button>
                <p>------------ Or ------------</p>
                <button id="email_login"><a href="{{ route('mobileLogin') }}" target="_blank">Login with Mobile</a></button>
                <p>Don't have an account? <a href="{{ route('login') }}">SignUp</a></p>
                <p><a href="/">Back to Home</a></p>
            </div>

        </div>
    </div>
@endsection
