@section('footer-script')

<script src="{{ asset("assets/plugins/intlTelInput/js/intlTelInput.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/plugins/intlTelInput/js/utils.js") }}" type="text/javascript"></script>

<script>
    document.querySelectorAll('input[name="identity_type"]').forEach((elem) => {
        elem.addEventListener("change", function(event) {
            document.querySelectorAll('.attachment-section').forEach((section) => {
                section.style.display = 'none';
            });
            let selectedSection = document.getElementById(event.target.value.toLowerCase() +
                '_section');
            selectedSection.style.display = 'block';
        });
    });
</script>

<script>

    const base_url = "{{ url('/') }}";
    const errorMsg = $('.error-msg');
    const captchaDiv = $('#captchaDiv');


    let hit = "{{ Session::get('hit') }}";
    if (hit >= 3) {
        captchaDiv.css('display', 'block');
        grecaptcha.reset();
    }

    $(document).bind('keypress', function(e) {
        if (e.keyCode == 13) {
            checkUserInformation()
        }
    });

    function checkUserInformation() {
        if ($("#email").val() == '' || $("#passowrd").val() == '') {
            errorMsg.html("Please enter your email and password properly!");
            return false;
        }

        $("#btnSignIn").prop('disabled', true); // disable button
        $("#btnSignIn").html('<i class="fa fa-cog fa-spin"></i> Loading...');
        errorMsg.html("");
        $.ajax({
            url: '/login/check',
            type: 'POST',
            data: {
                email: $('input[name="email"]').val(),
                password: $('input[name="password"]').val(),
                g_recaptcha_response: $('#g-recaptcha-response').val(),
                _token: $('input[name="_token"]').val()
            },
            datatype: 'json',
            success: function(response) {
                if (response.responseCode === 1) {
                    window.location = base_url + response.redirect_to;
                } else {
                    if (response.hit >= 3) {
                        captchaDiv.css('display', 'block');
                        grecaptcha.reset();
                    }
                    errorMsg.html(response.msg);
                }
                $("#btnSignIn").prop('disabled', false); // disable button
                $("#btnSignIn").html('Sign In');
            },
            error: function(jqHR, textStatus, errorThrown) {
                // Reset error message div and put the message inside
                errorMsg.html(jqHR.responseJSON.message);
                // console.log(jqHR.responseJSON.message)
                console.log(jqHR, textStatus, errorThrown);
                $("#btnSignIn").prop('disabled', false); // disable button
                $("#btnSignIn").html('Sign In');
            }
        });
    }

    $("#email_address").intlTelInput({
        hiddenInput: "email_address",
        onlyCountries: ["bd"],
        initialCountry: "BD",
        placeholderNumberType: "MOBILE",
        separateDialCode: true,
    });

    $("#user_mobile_no").intlTelInput({
        hiddenInput: "user_mobile_no",
        onlyCountries: ["bd"],
        initialCountry: "BD",
        placeholderNumberType: "MOBILE",
        separateDialCode: true,
    });

    $(document).on('click','.Next1',function(e){

        // var email_address = $('#email_address').val();

        var email_address = $("#email_address").intlTelInput("getNumber");

        if( email_address == '')
        {
            $("#email_address").addClass('error');
            $(".error-message-nid").text("Please enter your email address");
            return false;
        }
        else {
            $("#email_address").removeClass('error');
            $(".error-message-nid").text("");
        }

        // if( !validateEmail(email_address)) {
        //     $("#email_address").addClass('error');
        //     $(".error-message-nid").text("Please enter valid email address");
        //     return false;
        // }

        // if(email_address.length < 10 ){
        //     $(".error-message-nid").text("Please enter your 10 or 13 digit nid number.");
        //     return  false
        // }else{
        //     $(".error-message-nid").text("");
        // }

        btn = $(this);
        btn_content = btn.html();
        btn.html('<i class="fa fa-spinner fa-spin"></i> &nbsp;'+btn_content);
        // btn.prop('disabled', true);

        $("#otpnext1").prop('disabled', true); // disable button
        $.ajax({
            url: '/login/otp-login-validation-with-token-provide',
            type: 'post',
            data: {
                _token: $('input[name="_token"]').val(),
                'email_address': email_address,
                // 'project_id': project_id,
                // 'otp' : $('#otpForm').find('input[name=otp]:checked').val()
            },
            success: function (response) {
                btn.prop('disabled', false);
                btn.html(btn_content);

                if(response.responseCode == 1)
                {
                    timerCounter= setInterval('secondPassed()', 1000);
                    seconds.value = seconds.defaultValue;
                    $(".error-message-message-login").hide();
                    // $("#email_address").prop("disabled", true)
                    $('#otp_step_1').css("display", "none");
                    $('#otpnext1').css("display", "none");
                    $('#otp_step_2').css("display", "block");
                    $('#otpnext2').css("display", "block");
                    $('#otpnext3').css("display", "block");

                    $('#loading_send_sms').html('Sending OTP <i class="fa fa-spinner fa-spin"></i>');
                    ///// ajax call
                    // $('.modal-title').html('<span class="text-bold">Your email Address:  '+response.user_email+'</span>');
                    $('.modal-title').addClass('text-center');
                    checksmsStatus(response.queue_id);
                }
                else
                {
                    $(".error-message-message-login").show();
                    // $(".div_error").html(response.msg);
                    $(".div_error").html("<div  class='alert alert-danger alert-dismissible error-message-message-login'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>"+response.msg+"</div>");
                    return false;
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
    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( $email );
    }
    $(document).on('click','.Next2',function(e){
        btn.prop('disabled', true);
        var login_token = $('#login_token').val();
        var project_id = $('#project_name').val();
        var email_address = $("#email_address").intlTelInput("getNumber");
        // var email_address = $('#email_address').val();
        if(!login_token)
        {
            alert('OTP should be given');
            return false;
        }

        if(!email_address)
        {
            alert('Data has mismatch');
            return false;
        }


        btn = $(this);
        btn_content = btn.html();
        btn.html('<i class="fa fa-spinner fa-spin"></i> &nbsp;'+btn_content);

        $.ajax({
            url: '/login/otp-login-check',
            type: 'post',
            data: {
                _token: $('input[name="_token"]').val(),
                'email_address': email_address,
                'login_token' : login_token,
                'project_id' : project_id
            },
            success: function (response) {

                btn.html(btn_content);
                btn.prop('disabled', false);

                if(response.responseCode == 1)
                {
                    window.location.href = response.redirect_to;
                }
                else if(response.msg == 'OTP Time Expired!.Please Try again'){
                    $('#resend_link').css("display", "block");
                }
                else
                {
                    $(".error-message-message-login").show();
                    // $(".message_disp").html(response.msg);
                    $(".div_error").html("<div  class='alert alert-danger alert-dismissible error-message-message-login'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>"+response.msg+"</div>");

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

    $(document).on('click','.resend_otp',function(e){
        // btn.prop('disabled', true);
        $('#login_token').val('');
        var project_id = $('#project_name').val();

        var email_address = $("#email_address").intlTelInput("getNumber");
        // var email_address = $('#email_address').val();

        if(!email_address)
        {
            alert('Data has mismatch');
            return false;
        }


        btn = $(this);
        btn_content = btn.html();
        btn.html('<i class="fa fa-spinner fa-spin"></i> &nbsp;'+btn_content);

        $.ajax({
            url: '/login/otp-resent',
            type: 'post',
            data: {
                _token: $('input[name="_token"]').val(),
                'email_address': email_address,
            },
            success: function (response) {

                btn.html(btn_content);
                // btn.prop('disabled', false);

                //console.log(response);
                //alert(response);


                if(response.responseCode == 1)
                {
                    $('#resend_link').css("display", "none");
                    $('#loading_send_sms').css("display", "block");
                    $('#loading_send_sms').html('Sending OTP <i class="fa fa-spinner fa-spin"></i>');
                    $('#resend_link').css("display", "none");
                    checksmsStatus(response.queue_id);

                    // checksmsStatus(response.sms_id,response.otp_expired);
                }
                else
                {
                    $(".success-message-message-login").hide();
                    $(".error-message-message-login").show();
                    // $(".message_disp").html(response.msg);
                    $(".div_error").html("<div  class='alert alert-danger alert-dismissible error-message-message-login'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>"+response.msg+"</div>");
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
                if(seconds == 0){
                    seconds = 180;
                }

                timerCounter= setInterval('secondPassed()', 1000);
            }
        });
    });


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
            || (e.keyCode >= 35 && e.keyCode <= 39))
        {

            var thisVal = $(this).val();
            if (thisVal.indexOf(".") != -1 && e.key == '.') {
                return false;
            }
            $(this).removeClass('error');
            return true;
        }
        else
        {
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
    $(document).on('keypress',  function (e) {
        if($('#otp_step_1').is(':visible')) {
            var key = e.which;
            if (key == 13) { //This is an ENTER
                $('#otpnext1').click();
            }
        }
    });
    $(document).on('keypress',  function (e) {
        if($('#otp_step_2').is(':visible')) {
            var key = e.which;
            if (key == 13) { //This is an ENTER
                $('#otpnext3').click();
            }
        }
    });


    //     function remainingtime(time) {
    //         var countDownDate = new Date(time).getTime();
    // // Update the count down every 1 second
    //         var x = setInterval(function() {
    //             console.log('timer');
    //
    //             // Get today's date and time
    //             var now = new Date().getTime();
    //
    //             // Find the distance between now and the count down date
    //             var distance = countDownDate - now;
    //
    //             // Time calculations for days, hours, minutes and seconds
    //
    //             var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    //             var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    //
    //             // Output the result in an element with id="demo"
    //             if(minutes <=0){
    //                 document.getElementById("show_cowndown").innerHTML =seconds+' seconds';
    //             }else{
    //                 document.getElementById("show_cowndown").innerHTML = minutes + " minute:" + seconds+' seconds';
    //             }
    //
    //
    //             // If the count down is over, write some text
    //             if (distance < 0) {
    //                 clearInterval(x);
    //                 $(".success-message-message-login").hide();
    //                 $(".error-message-message-login").hide();
    //                 $('#display_before').css("display", "none");
    //                 $('#resend_link').css("display", "block");
    //             }
    //         }, 1000);
    //     }
    var timerCounter;
    var seconds = 180; //**change 180 for any number you want, it's the seconds **//
    function secondPassed() {

        $('#resend_link').css("display", "none");
        var minutes = Math.round((seconds - 30)/60);
        var remainingSeconds = seconds % 60;
        if (remainingSeconds < 10) {
            remainingSeconds = "0" + remainingSeconds;
        }

        document.getElementById('show_cowndown').innerHTML = minutes + ":" + remainingSeconds;
        if (seconds == 0) {
            clearInterval(timerCounter);
            document.getElementById('show_cowndown').innerHTML = "Expired!";

            $(".success-message-message-login").hide();
            $(".error-message-message-login").hide();
            $('#display_before').css("display", "none");
            $('#resend_link').css("display", "block");

        } else {
            seconds--;
        }

    }



    function checksmsStatus(email_id,expiredtime=null) {
        var currenttime = new Date();
        var currenttimemilisecond = currenttime.getTime();
        var after10 = (currenttimemilisecond+(10*1000));
        var after20 = (currenttimemilisecond+(20*1000));
        var expiredtimemilisecond = new Date(expiredtime).getTime();

        var x = setInterval(function() {
            var currenttime2 = new Date().getTime();
            $.ajax({
                url: '/login/check-sms-send-status',
                type: 'post',
                data: {
                    _token: $('input[name="_token"]').val(),
                    'email_id': email_id,
                },
                success: function (response) {
                    console.log('checksmsStatus',response);
                    

                    if(response.responseCode == 1) {
                        if(response.sms_status ==1){
                            clearInterval(x);
                            $('#loading_send_sms').css("display", "none");
                            $(".error-message-message-login").hide();
                            $('.success-message-message-login').show().text(response.msg).delay(5000).fadeOut(300);
                            setTimeout("$('#display_before').css('display', 'block')", 5000);
                            $('#otp_step_1').css("display", "none");
                            $('#otpnext1').css("display", "none");
                            // remainingtime(expiredtime);
                        }else{
                            if (currenttime2 >expiredtimemilisecond){
                                clearInterval(x);
                                $('#loading_send_sms').html('Please Try after some times');
                            }else
                            if(currenttime2 >after20){
                                $('#loading_send_sms').html('Please wait, sending SMS <i class="fa fa-spinner fa-spin"></i>');
                            }else if(currenttime2 > after10){
                                $('#loading_send_sms').html('Sending SMS <i class="fa fa-spinner fa-spin"></i>');
                            }


                        }
                    }
                    else
                    {
                        clearInterval(x);
                        $('#loading_send_sms').html('Please Try after some times');
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
                    timerCounter=  setInterval('secondPassed()', 1000);
                }
            });

        }, 2000);
    }

    $( document ).ready(function() {
        $(".toggle-password-icon").click(function(e) {
            e.preventDefault();
            let togglePassword = document.getElementById("password");
            const add_class = togglePassword.getAttribute("type") === "password" ? "fa fa-eye" : "fa fa-eye-slash";
            const remove_class = togglePassword.getAttribute("type") === "password" ? "fa fa-eye-slash" : "fa fa-eye";
            const type = togglePassword.getAttribute("type") === "password" ? "text" : "password";
            $(this).removeClass(remove_class);
            $(this).addClass(add_class);
            togglePassword.setAttribute("type", type)
        });// end -:- Password Toggle Event
    });// end -:- Document Ready

</script>

@endsection