@extends('public_home.front')

@section("body")
<style>
    .iti {
    width: inherit;   
}
</style>
    <div id="otp_modal" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog user-login-modal-container">

            <!-- Modal content for OTP Login-->
            <div class="modal-content user-login-modal-body">
                <div class="modal-header user-login-modal-title">
                    <div class="modal-title" style="font-size: 15px;">
                        @if( app()->getLocale() =='bn')
                            রেজিস্ট্রেশন প্রক্রিয়া ধাপ-১ (শুধুমাত্র প্রথমবারের জন্য)
                        @else
                            Registration process step-1 (For the first time only).
                        @endif
                    </div>
                </div>

                @include('Training::signup-indentification')

                <div class="modal-body login-otp user-login-modal-content user_mobile_verify_div">
                    <div style="display: none" class="error-message-message-login alert alert-danger"></div>
                    <div style="display: none" class="success-message-message-login alert alert-success"></div>
                    <div id="loading_send_sms" class="text-center" style="font-size: 16px;">
                    </div>

                    <div class="row">
                        <div class="col-md-12 otp_step_1" id="otp_step_1">
                            <div class="form-group row otp_receiver">
                                {!! Form::label('otp_by', trans('Signup::messages.otp_mobile_no'), array('class' => 'col-sm-4 col-form-label', 'id' => '')) !!}

                                <div class="col-sm-8">
                                    {!! Form::text('user_mobile', '', ['class' => 'form-control input-md required phone_or_mobile required-star' , 'id'=>'user_mobile']) !!}
                                    {{--                                    {!! Form::text('phone', '', array('class' => 'form-control phone', 'placeholder' => 'Enter Phone Number.','id'=>'phone_number')) !!}--}}
                                    <span class="error-message-nid" style="color: red"></span>
                                </div>
                            </div>
                        </div>

                        <div id="otp_step_2" class="col-md-12" style="display:none;">
                            <div class="form-group row">
                                <div style="display: none" class="alert alert-danger error-message alert-dismissible">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×
                                    </button>
                                    <span class="error-message"></span></div>

                                {!! Form::label('login_token', 'OTP:', array('class' => 'col-md-3')) !!}
                                <div class="col-md-9">
                                    {!! Form::text('login_token', '', array('class' => 'form-control onlyNumber', 'placeholder' => trans('Signup::messages.enter_otp'),'id'=>'login_token')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">

                            <div id="resend_link" style="display: none; font-size: 16px; text-align: center;"
                                 class="login-need-help col-md-12">
                                <br>
                                @if( app()->getLocale() =='bn')
                                    কোন OTP পান নি?
                                @else
                                    Don't receive the OTP?
                                @endif

                                <b>
                                    <a href="javascript:void(0)" class="resend_otp" style="color: red;">
                                        @if( app()->getLocale() =='bn')
                                            OTP আবার পাঠান
                                        @else
                                            Resend OTP
                                        @endif
                                    </a>
                                </b>

                            </div>
                            <br>
                            <p id="countdown" style="text-align: center; display: none">Time left: 3:00</p>

                            <button type="button" class="btn btn-danger float-right  Next1" id="otpnext1"
                                    style="background-color:rgba(255, 101, 132, 1) ; float: right "
                                    onclick="sendOTP();">
                                <strong> {{ trans('Signup::messages.send_otp')}} </strong></button>
                            <div id="otpnext2" style="display:none;">
                                <button type="button" id="otpnext3" disabled style="float:right;"
                                        class="btn btn-success float-right Next2">{{ trans('Signup::messages.verify')}}</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('footer-script')

    <script src="{{ asset("assets/scripts/sweetalert2.all.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/scripts/intlTelInput-jquery_v16.0.8.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/scripts/utils_v16.0.8.js") }}" type="text/javascript"></script>

    <script>

        $("#user_mobile").intlTelInput({
            hiddenInput: "user_mobile",
            initialCountry: "BD",
            placeholderNumberType: "MOBILE",
            separateDialCode: true
        });

        $(document).ready(function () {
            $('#otp_modal').modal('show');
        });


        // count down timer for otp section
        let resentLinkCountDownFlag = 0;

        function startCountdown(duration, display) {

            var countdownInterval = setInterval(function () {
                var minutes = Math.round((duration - 30) / 60);
                var remainingSeconds = duration % 60;
                if (remainingSeconds < 10) {
                    remainingSeconds = "0" + remainingSeconds;
                }

                display.innerHTML = "Time left: " + minutes + ":" + remainingSeconds;

                if (duration == 0) {
                    clearInterval(countdownInterval);
                    if (resentLinkCountDownFlag == 1) {
                        $('#countdown').css("display", "none");
                        // Show the "Resend OTP" section
                        $('#resend_link').css('display', 'block');
                        $('#otp_step_2').css("display", "none");
                    } else {
                        $('#otp_step_2').css("display", "none");
                        display.innerHTML = "Your OTP Expired ! Refresh the Page";
                    }

                } else {
                    duration--;
                }
            }, 1000);
            resentLinkCountDownFlag++;
        }


        function sendOTP() {
            var user_mobile = $("#user_mobile").intlTelInput("getNumber");

            if ($("#user_mobile").intlTelInput("isValidNumber")) {
                // Validate the phone number
                $('#loading_send_sms').html('Sending OTP <i class="fa fa-spinner fa-spin"></i>');

                $.ajax({
                    url: '{{ route('signup.identity_verify_otp') }}',
                    type: 'POST',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        user_mobile: user_mobile,
                    },
                    datatype: 'json',
                    success: function (response) {
                        if (response.status === 'error') {
                            Swal.fire({
                                title: response.message,
                                icon: 'error',
                                onAfterClose: () => {
                                    location.reload(true);
                                }
                            });
                        }

                        if (response.status === 'success') {
                            if (response.statusCode == 200) {
                                $('#loading_send_sms').css("display", "none");
                                $('.success-message-message-login').show().text(response.msg).delay(5000).fadeOut(300);
                                $(".error-message-message-login").hide();
                                $('#otp_step_1').css("display", "none");
                                $('#otpnext1').css("display", "none");
                                $('#otp_step_2').css("display", "block");
                                $('#otpnext2').css("display", "block");
                                $('#otpnext3').css("display", "block");
                                $('#countdown').css("display", "block");
                                $('#resend_link').css('display', 'none');
                                startCountdown(180, document.getElementById("countdown"));


                                ///// ajax call
                                $('.modal-title').html('<span class="text-bold">' + response.user_mobile + '</span>');
                                $('.modal-title').addClass('text-center');
                            }
                        }
                    },
                    error: function (jqHR, textStatus, errorThrown) {

                    },
                    beforeSend: function () {
                    }

                });

            } else {
                Swal.fire(
                    'Invalid Mobile Number  ' + user_mobile,
                    '',
                    'error'
                );
            }

        }


        $(document).on('click', '.Next2', function (e) {
            var login_token = $('#login_token').val();
            var phone_number = $("#user_mobile").val();

            $.ajax({
                url: '{{ route('signup.otp_verify') }}',
                type: 'post',
                data: {
                    _token: $('input[name="_token"]').val(),
                    'phone': phone_number,
                    'otp_value': login_token,
                },
                success: function (response) {

                    if (response.statusCode == 1) {
                        $('.success-message-message-login').show().text(response.msg).delay(5000).fadeOut(300);
                        // Delay hiding the modal
                        setTimeout(function () {
                            $('#otp_modal').modal('hide');
                        }, 3000);

                        // Redirect after a delay
                        setTimeout(function () {
                            window.location.href = response.redirect_to;
                        }, 3000);
                    } else if (response.msg == 'OTP Time Expired!.Please Try again') {
                        $('#resend_link').css("display", "block");
                    } else {
                        Swal.fire(
                            response.msg,
                            '',
                            'error'
                        )
                        // $(".error-message-message-login").show();
                        // $(".error-message-message-login").text(response.msg);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);

                },
                beforeSend: function (xhr) {
                    console.log('before send');
                },
                complete: function () {
                    //completed
                }
            });
        });


        $(document).on('click', '.resend_otp', function (e) {
            btn = $(this);
            btn_content = btn.html();
            btn.html('<i class="fa fa-spinner fa-spin"></i> &nbsp;' + btn_content);
            sendOTP();
        });


        // check otp length
        $('.onlyNumber').on('keyup', function (e) {

            var login_token = $('#login_token').val();
            var submitButton = $('#otpnext3');

            if (login_token.length === 6) {
                submitButton.prop('disabled', false);
            } else {
                submitButton.prop('disabled', true);
            }
        })

        // check otp input can not input any string value
        $('.onlyNumber').on('keydown', function (e) {

            //period decimal
            if ((e.which >= 48 && e.which <= 57)
                //numpad decimal
                || (e.which >= 96 && e.which <= 105)
                // Allow: backspace, delete, tab, escape, enter and .
                || $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1
                // Allow: Ctrl+A
                || (e.keyCode == 65 && e.ctrlKey === true)
                // Allow: Ctrl+C
                || (e.keyCode == 67 && e.ctrlKey === true)
                // Allow: Ctrl+V
                || (e.keyCode == 86 && e.ctrlKey === true)
                // Allow: Ctrl+X
                || (e.keyCode == 88 && e.ctrlKey === true)
                // Allow: home, end, left, right
                || (e.keyCode >= 35 && e.keyCode <= 39)) {

                var thisVal = $(this).val();
                if (thisVal.indexOf(".") != -1 && e.key == '.') {
                    return false;
                }
                $(this).removeClass('error');
                return true;
            } else {
                $(this).addClass('error');
                return false;
            }
        }).on('paste', function (e) {
            var $this = $(this);
            setTimeout(function () {
                $this.val($this.val().replace(/[^0-9]/g, ''));
            }, 4);
        }).on('keyup', function (e) {
            var $this = $(this);
            setTimeout(function () {
                $this.val($this.val().replace(/[^0-9]/g, ''));
            }, 4);
        });
        $(document).on('keypress', function (e) {
            if ($('#otp_step_1').is(':visible')) {
                var key = e.which;
                if (key == 13) { //This is an ENTER
                    $('#otpnext1').click();
                }
            }
        });
        $(document).on('keypress', function (e) {
            if ($('#otp_step_2').is(':visible')) {
                var key = e.which;
                if (key == 13) { //This is an ENTER
                    $('#otpnext3').click();
                }
            }
        });
    </script>

    <script>
        $(document).on('change', '#signup_type', function (){
            var type = $(this).val();
            if(type == 'trainee'){
                $('.trainee_action_div').removeClass('hidden');
                $('.user_mobile_verify_div').addClass('hidden');
            }else{
                $('.trainee_action_div').addClass('hidden');
                $('.user_mobile_verify_div').removeClass('hidden');
            }
        })
    </script>
@endsection