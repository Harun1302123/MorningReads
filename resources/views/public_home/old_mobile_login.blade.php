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

            <label for="mobile">Mobile Number</label>
            <input type="number" id="mobile" placeholder="Enter your number">

            <div id="login">
                <button><a href="mobileotpform.html" style="color: white; text-decoration: none;"
                        target="_blank">Next</a></button>
                <p>------------ Or ------------</p>
                <button id="email_login"><a href="{{ route('emailLogin') }}">Login with Email</a></button>
                <p>Don't have an account? <a href="{{ route('login') }}">SignUp</a></p>
                <p><a href="/">Back to Home</a></p>
            </div>

        </div>
    </div>
@endsection
