@extends('public_home.front')

@include('public_home.login_css')

@section('body')
    <div class="login-details my-5 container">

        @include('partials.messages')

        <div id="form">
            <div id="title">
                <h2>Login</h2>
            </div>


            <div class="modal-body login-otp user-login-modal-content">
                {!! Form::open(array('url' => '', 'method' => '' ,'id'=>'otpForm')) !!}
                <div class="div_error">

                </div>


                <div style="display: none" class="success-message-message-login alert alert-success"></div>
                <div id="loading_send_sms" class="text-center" style="font-size: 16px;"></div>
                <div class="row">
                    <div class="col-md-12 otp_step_1" id="otp_step_1">
                        <label for="mobile">Mobile Number</label>
                        <div class="form-group row otp_receiver">
                            {{-- {!! Form::label('otp_by', 'Mobile Number:', array('class' => 'col-sm-3 col-form-label', 'id' => '')) !!} --}}
                            <div class="col-md-12">
                                {!! Form::text('email', '', $attributes = ['class' => ' required bd_mobile', 'placeholder' => 'Enter your Number', 'id' => 'email_address']) !!}
                                <span class="error-message-nid" style="color: red"></span>
                            </div>
                        </div>
                    </div>

                    <div id="otp_step_2" class="col-md-12" style="display:none;">
                        <label for="">OTP</label>
                        <div class="form-group row">
                            <div style="display: none" class="alert alert-danger error-message alert-dismissible"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><span class="error-message"></span></div>

                            <div class="col-md-9">
                                {!! Form::text('login_token', '', array('class' => 'form-control', 'placeholder' => 'Enter Your OTP','id'=>'login_token')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div id="login">
                            <button type="button"  class=" Next1" id="otpnext1" style="color: white; text-decoration: none;">Next</button>
                            {{-- <button type="button" class="btn btn-danger float-right  Next1" id="otpnext1" style="background-color:rgba(255, 101, 132, 1) ">Login/Next</button>--}}
                            <div id="otpnext2" style="display:none;">
                                <button type="button" id="otpnext3" style="color: white; text-decoration: none;" class="Next2">Submit</button>
                            </div>

                            <p>------------ Or ------------</p>
                            <button id="email_login"><a href="{{ route('emailLogin') }}">Login with Email</a></button>
                            <p>Don't have an account? <a href="{{ route('signup') }}">SignUp</a></p>
                            <p><a href="/">Back to Home</a></p>
                        </div>
                    </div>


                    <div class="form-group col-md-12">
                        <div id="resend_link" style="display: none; font-size: 16px; text-align: center;" class="login-need-help col-md-12">
                            <br>
                            Don't receive the OTP?
                            <b>
                                <a   href="javascript:void(0)"  class="resend_otp" style="color: red;">Resend OTP</a>
                            </b>

                        </div>
                        <br>
                        <p id="display_before" style="font-size: 16px;display: none; text-align: center;"  >The OTP will be expired in <span id="show_cowndown"></span></p>
                    </div>

                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>
@endsection

@include('public_home.login_js')