/**
 * Set default X-CSRF-TOKEN for all future ajax request.
 */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function enableVerifyButton() {
    var submit_button_status = false;

    // const nationality_type = $('input[name="nationality_type"]:checked').val();
    const nationality_type = $("#nationality_types").val();
    var etin_number = $('input[name="etin_number"]').val();
    var user_DOB = $('input[name="user_DOB"]').val();

    if (nationality_type == 'foreign') {

        const identity_type_foreign = $('input[name="identity_type_foreign"]:checked').val();
        if (identity_type_foreign == 'tin') {
            if (etin_number && user_DOB) {
                submit_button_status = true;
            }
        } else if (identity_type_foreign == 'passport') {
            submit_button_status = true;
        }

    } else if (nationality_type == 'bangladeshi') {
        const identity_type_bd = $('input[name="identity_type_bd"]:checked').val();
        if (identity_type_bd == 'nid') {
            const user_nid = $('input[name="user_nid"]').val();
            if (user_nid && user_DOB) {
                submit_button_status = true;
            }
        } else if (identity_type_bd == 'tin') {
            if (etin_number && user_DOB) {
                submit_button_status = true;
            }
        }
    }

    if (submit_button_status) {
        $("#nid_tin_verify").prop("disabled", false);
    } else {
        $("#nid_tin_verify").prop("disabled", true);
    }
}

$(document).ready(function () {
    $(".reload_page").on("click", function (){
        window.location.reload(true);
    });

    // enableVerifyButton();
    $('input[name="nationality_type"]').on('change', enableVerifyButton);
    $('input[name="identity_type_foreign"]').on('change', enableVerifyButton);
    $('#user_DOB').on('input', enableVerifyButton);
    $('#user_DOB').on('change', enableVerifyButton);


    var today = new Date();
    var yyyy = today.getFullYear();
    // $('#datetimepicker').datetimepicker({
    //     viewMode: 'years',
    //     format: 'DD-MMM-YYYY',
    //     maxDate: 'now',
    //     minDate: '01/01/' + (yyyy - 110),
    //     ignoreReadonly: true,
    // }).on('dp.show', function () {
    //     $(".dateMbl").attr('readonly', true);
    // }).on('dp.hide', function () {
    //     $(".dateMbl").attr('readonly', false);
    // });

    $('#datetimepicker4').datetimepicker({
        format: 'L',
        format: 'DD-MMM-YYYY',
        maxDate: 'now',
        minDate: '01/01/' + (yyyy - 110),
        ignoreReadonly: true,
    });

    $('#datetimepicker5').datetimepicker({
        format: 'L',
        format: 'DD-MMM-YYYY',
        maxDate: 'now',
        minDate: '01/01/' + (yyyy - 110),
        ignoreReadonly: true,
    });
    $('#datetimepicker6').datetimepicker({
        format: 'L',
        format: 'DD-MMM-YYYY',
        maxDate: 'now',
        minDate: '01/01/' + (yyyy - 110),
        ignoreReadonly: true,
    });


    $('.passportDP').datetimepicker({
        viewMode: 'years',
        format: 'DD-MMM-YYYY',
        maxDate: 'now',
        minDate: '01/01/' + (yyyy - 110)
    });

    $(".passExpiryDate").datetimepicker({
        viewMode: 'years',
        format: 'DD-MMM-YYYY',
        maxDate: '01/01/' + (yyyy + 20),
        minDate: '01/01/' + (yyyy - 10)
    });

    /**
     * Form validation
     */
    $("#identityVerifyForm").validate({
        errorPlacement: function () {
            return false;
        },
        submitHandler: function (form) {
            var identity_type = getSelectedIdentityType();
            
            // if needed recaptcha varificaton
            if(grecaptcha.getResponse().length == 0){
                Swal.fire(
                    'Recaptcha required 1',
                    '',
                    'error'
                )
                return false
            }

            if (identity_type === 'nid') {
                $('#NidTinVerifyModal').modal('show');
                return false;
            } else if (identity_type === 'tin') {
                $('#NidTinVerifyModal').modal('show');
                return false;
            } else if (identity_type === 'passport') {
                form.submit();
            } else {
                alert('Sorry! unknown identity type');
                return false;
            }
        }
    });


    /**
     * Start NID API calling on shown NidTinVerifyModal
     */
    $("#NidTinVerifyModal").on('shown.bs.modal', function () {

        const nationality_type = $("#nationality_types").val();
        const identity_type = getSelectedIdentityType('#nationality_types');

        if (identity_type == 'nid') {
            $("#verify_modal_title").text("বাংলাদেশ নির্বাচন কমিশন থেকে জাতীয় পরিচয়পত্র যাচাই হচ্ছে");
            $("#verify_modal_title_img").attr('src', '/assets/images/ec.png');
        } else {
            $("#verify_modal_title").text("ETIN Verification");
            $("#verify_modal_title_img").attr('src', '/assets/images/nbrlogo.jpg');
        }

        $("#NidTinVerificationResponse").slideDown('slow', function () {
            $("#NidTinVerificationResponse").html('<i class="fa fa-spinner fa-spin"></i>  ডাটা ভেরিফিকেশন করা হচ্ছে, অনুগ্রহপূর্বক অপেক্ষা করুন....');

            verifyNidOrTin(nationality_type, identity_type);
        });
    });

    /**
     * Reset html element on hidden NidTinVerifyModal
     */
    $('#NidTinVerifyModal').on('hidden.bs.modal', function () {

        // Clear div of NID Verification Response
        document.getElementById('NidTinVerificationResponse').innerHTML = '';

        // Reset NID info, name, gender, dob
        document.getElementById('VerifiedNIDInfo').classList.add('d-none');
        document.getElementById('nid_tin_image').setAttribute('src', '');
        document.getElementById('nid_tin_name').innerHTML = '';
        document.getElementById('nid_tin_dob').innerHTML = '';
        //document.getElementById('nid_gender').innerHTML = '';
        // Reset NID info, name, gender, dob

        // Re-hide the 'Save & continue' button
        document.getElementById('SaveContinueBtn').classList.add('d-none');


        $('.errorMsgNID').slideUp();

        $("#verify_modal_title").text("");
        $("#verify_modal_title_img").attr('src', '');

        // Refresh the page
        // location.reload();
    });

});

/**
 * Get selected identity type [e.g. NID, TIN, Passport]
 * @returns {*}
 */
function getSelectedIdentityType() {
    // var nationality_type = document.querySelector('input[name="nationality_type"]:checked').value;
    const nationality_type = $("#nationality_types").val();
    var identity_type;
    if (nationality_type === 'bangladeshi') {
        identity_type = document.querySelector('input[name="identity_type_bd"]:checked').value;
    } else if (nationality_type === 'foreign') {
        identity_type = document.querySelector('input[name="identity_type_foreign"]:checked').value;
    }
    return identity_type;
}



function VerifyNID() {
    var info_err = $('.errorMsgNID'); //get error message div
    var nid_number = document.querySelector("input[name='user_nid']").value;
    var user_DOB = document.querySelector("input[name='nid_dob']").value;
    const identity_type = document.querySelector('input[name="identity_type"]:checked').value;

    // const identity_type = document.querySelector('input[name="identity_type_bd"]:checked').value;


    var nid_length = nid_number.length;
    if (nid_length === 10 || nid_length === 13 || nid_length === 17) {
        $.ajax({
            url: '/client/signup/identity-verify/nid-tin-verify',
            type: 'GET',
            data: {
                nid_number: nid_number,
                user_DOB: user_DOB,
                identity_type: identity_type,
                g_recaptcha_response: grecaptcha.getResponse()
            },
            datatype: 'json',
            success: function (response) {
                // Print validation errors or others error (Execution, try-catch, custom condition)
                if (response.status === 'error') {
                    info_err.hide().empty();
                    if (typeof response.message === 'object') {
                        $.each(response.message, function (index, error) {
                            info_err.removeClass('hidden').append('<li>' + error + '</li>');
                        });
                    } else {
                        info_err.removeClass('hidden').html(response.message);
                    }

                    $("#ETINResponseCountMsg").slideUp('slow', function () {
                        info_err.slideDown('slow');
                        // info_err.delay(2000).slideUp(1000, function () {
                        //     $('#ETInVerifyModal').modal('hide');
                        // });
                    });
                }
                // End Print validation errors or others error (Execution, try-catch, custom condition)


                if (response.status === 'success') {

                    var ETINVerifySuccessMsg = document.getElementById('ETINVerifySuccessMsg');
                    // Reset ETINVerifySuccessMsg div
                    ETINVerifySuccessMsg.style.display = 'none';

                    document.getElementById('ETINResponseCountMsg').innerHTML = 'Congrats!!! Your ETIN is valid.';
                    $('#ETINResponseCountMsg').delay(1000).slideUp(1000, function () {

                        $('#VerifiedETINInfo').slideDown('slow');
                        document.getElementById('etin_name').innerHTML = response.data.nameEn;
                        document.getElementById('etin_father_name').innerHTML = response.data.father_name;
                        var etin_dob = new Date(response.data.dob);
                        document.getElementById('etin_dob').innerHTML = etin_dob.getDate() + "-" + etin_dob.toLocaleString('default', {month: 'short'}) + "-" + etin_dob.getFullYear();

                        // put etin data into hidden field
                        //document.getElementById('verified_etin_data').value = JSON.stringify(response.data);

                        document.getElementById('etinSaveContinueBtn').classList.remove('hidden');
                    });
                }
            },
            error: function (jqHR, textStatus, errorThrown) {
                info_err.hide().empty();
                info_err.removeClass('hidden').html(errorThrown);
                $("#ETINResponseCountMsg").slideUp('slow', function () {
                    info_err.slideDown('slow');
                    // info_err.delay(1000).slideUp(1000, function () {
                    //     $('#ETINVerifyModal').modal('hide');
                    // });
                });
                // On modal close, disable ETIN verification calling.
                clearTimeout(setRecursionForETINVerification);
            },
            beforeSend: function () {
            }

            // datatype: 'json',
            // success: function (response) {
            //
            //     console.log(response);
            //     var NIDVerificationTimeCounting = document.getElementById('NIDVerificationTimeCounting');
            //
            //     // Print validation errors or others error (Execution, try-catch, custom condition)
            //     if (response.status === 'error') {
            //         // Hide NIDVerificationTimeCounting div
            //         NIDVerificationTimeCounting.style.display = 'none';
            //
            //         // Reset error message div and put the message inside
            //         info_err.hide().empty();
            //
            //         if (typeof response.message == 'object') {
            //             Object.entries(response.message).forEach(message => {
            //
            //                 const [key, messages] = message;
            //
            //                 if (typeof messages == 'object') {
            //
            //                     Object.entries(messages).forEach(messages => {
            //                         const [index, value] = message;
            //                         // info_err.removeClass('d-none').append(value + '<br/>');
            //                         info_err.show().append('<li>' + error + '</li>');
            //                     });
            //                 } else {
            //                     info_err.show().html(messages);
            //                 }
            //
            //             });
            //         } else {
            //             info_err.show().html(response.message);
            //         }
            //
            //         // Slide up NIDVerificationResponse div and slide down error message div
            //         $("#NIDVerificationResponse").slideUp('slow', function () {
            //             info_err.slideDown('slow');
            //         });
            //     }
            //     // End Print validation errors or others error (Execution, try-catch, custom condition)
            //
            //     if (response.status === 'success') {
            //         if (response.statusCode === 200) {
            //             // Hide NIDVerificationTimeCounting div
            //             NIDVerificationTimeCounting.style.display = 'none';
            //             // Put success message inside the NIDVerificationResponse div
            //             document.getElementById('NIDVerificationResponse').innerHTML = 'Congrats!!! Your NID is valid.';
            //             // Slide up NIDVerificationResponse div and slide down the NID details div
            //             $('#NIDVerificationResponse').delay(1000).slideUp(1000, function () {
            //
            //                 // NID details div slide down and put the details inside
            //                 $('#VerifiedNIDInfo').slideDown('slow');
            //                 //$('#step_one').slideUp('slow');
            //                 $('#nid_verify').slideUp('slow');
            //                 $('#nid_save').slideDown('slow');
            //                 $('input[name="user_nid"]').val(nid_number);
            //                 $('input[name="nid_name"]').val(response.data.nameEn);
            //                 if (response.data.gender === "male") {
            //                     document.getElementById('maleRadio').checked = true;
            //                 } else if (response.data.gender === "female") {
            //                     $document.getElementById('femaleRadio').checked = true;
            //                 } else {
            //                     $document.getElementById('otherRadio').checked = true;
            //                 }
            //                 $("#nid_nationality").val("18").change();
            //                 $("#nid_nationality").attr("readonly", true);
            //                 $("#nid_nationality").css({ 'pointer-events': 'none' });
            //                 var nid_dob = new Date(response.data.dob);
            //                 document.getElementById('save_nid_dob').innerHTML = nid_dob.getDate() + "-" + nid_dob.toLocaleString('default', { month: 'short' }) + "-" + nid_dob.getFullYear();
            //             });
            //         }
            //     } else {
            //         if (response.statusCode === 400) {
            //             // Hide NIDVerificationTimeCounting div
            //             $('#NIDVerificationResponse').hide();
            //             info_err.hide().empty();
            //             info_err.removeClass('hidden').html('Invalid NID or Date of Birth.');
            //             info_err.slideDown('slow');
            //         }
            //         document.getElementById('NIDVerifyBtn').disabled = false;
            //     }
            // },
            // error: function (jqHR, textStatus, errorThrown) {
            //     // Reset error message div and put the message inside
            //     info_err.hide().empty();
            //     info_err.removeClass('hidden').html(errorThrown);
            //
            //     // Slide up NIDVerificationResponse div and slide down error message div
            //     $("#NIDVerificationResponse").slideUp('slow', function () {
            //         info_err.slideDown('slow');
            //     });
            // },
            // beforeSend: function () {
            //     // Reset error message div and put the message inside
            //     info_err.hide().empty();
            // }
        });
    } else {
        $("#NidTinVerificationResponse").slideUp('slow', function () {
            info_err.hide().empty();
            info_err.removeClass('hidden').html('Invalid NID length. It should be 10, 13 or 17 digits.');
            info_err.slideDown('slow');
        });
        document.getElementById('NIDVerifyBtn').disabled = false;
    }
}



function VerifyETIN() {
    var etin_number = document.getElementById("etin_number").value;
    var user_DOB = document.getElementById("etin_dob").value;
    const identity_type = document.querySelector('input[name="identity_type"]:checked').value;

    var info_err = $('.errorMsgTIN'); //get error message div

    if (etin_number == '' || user_DOB == '') {
        alert('Invalid ETIN No. or Date of Birth');
    }

    var etin_length = etin_number.length;

    if (etin_length >= 10 && etin_length <= 15) {
        $.ajax({
            url: '/client/signup/identity-verify/nid-tin-verify',
            type: 'GET',
            data: {
                etin_number: etin_number,
                user_DOB: user_DOB,
                identity_type: identity_type,
                g_recaptcha_response: grecaptcha.getResponse()
            },
            datatype: 'json',
            success: function (response) {
                // Print validation errors or others error (Execution, try-catch, custom condition)
                if (response.status === 'error') {
                    info_err.hide().empty();

                    if (typeof response.message == 'object') {
                        Object.entries(response.message).forEach(message => {

                            const [key, messages] = message;

                            if (typeof messages == 'object') {

                                Object.entries(messages).forEach(messages => {
                                    const [index, value] = message;
                                    // info_err.removeClass('d-none').append(value + '<br/>');
                                    info_err.show().append('<li>' + error + '</li>');
                                });
                            } else {
                                info_err.show().html(messages);
                            }

                        });
                    } else {
                        info_err.show().html(response.message);
                    }

                    $("#ETINResponseCountMsg").slideUp('slow', function () {
                        info_err.slideDown('slow');
                        // info_err.delay(2000).slideUp(1000, function () {
                        //     $('#ETInVerifyModal').modal('hide');
                        // });
                    });
                }
                // End Print validation errors or others error (Execution, try-catch, custom condition)


                if (response.status === 'success') {
                    var ETINVerifySuccessMsg = document.getElementById('ETINVerifySuccessMsg');
                    // Reset ETINVerifySuccessMsg div
                    ETINVerifySuccessMsg.style.display = 'none';

                    document.getElementById('ETINResponseCountMsg').innerHTML = 'Congrats!!! Your ETIN is valid.';

                    $('#ETINResponseCountMsg').delay(1000).slideUp(1000, function () {

                        $('#VerifiedETINInfo').slideDown('slow');

                        //$('#step_one').slideUp('slow');
                        $('#tin_verify').slideUp('slow');
                        $('#tin_save').slideDown('slow');

                        $('input[name="etin_name"]').val(response.data.nameEn);
                        $('input[name="user_etin"]').val(etin_number);
                        var etin_dob = new Date(response.data.dob);
                        document.getElementById('save_etin_dob').innerHTML = etin_dob.getDate() + "-" + etin_dob.toLocaleString('default', { month: 'short' }) + "-" + etin_dob.getFullYear();
                        // put etin data into hidden field
                        //document.getElementById('verified_etin_data').value = JSON.stringify(response.data);

                        //document.getElementById('etinSaveContinueBtn').classList.remove('hidden');
                    });

                }
            },
            error: function (jqHR, textStatus, errorThrown) {
                info_err.hide().empty();
                info_err.removeClass('hidden').html(errorThrown);

                $("#ETINResponseCountMsg").slideUp('slow', function () {
                    info_err.slideDown('slow');
                    // info_err.delay(1000).slideUp(1000, function () {
                    //     $('#ETINVerifyModal').modal('hide');
                    // });
                });
            },
            beforeSend: function () {
                info_err.hide().empty();
            }
        });
    } else {
        $("#ETINResponseCountMsg").slideUp('slow', function () {
            info_err.hide().empty();
            info_err.removeClass('hidden').html('The e-tin number must be between 10 and 15 digits.');
            info_err.slideDown('slow');
            // info_err.delay(1000).slideUp(1000, function () {
            //     $('#ETINVerifyModal').modal('hide');
            // });
        });

    }
}


function verifyNidOrTin(nationality_type, identity_type) {

    document.getElementById('nid_tin_image').style.display = "block";

    var nid_number = document.getElementById("user_nid").value;
    var etin_number = document.getElementById("etin_number").value;
    var user_DOB = document.getElementById("user_DOB").value;

    var info_err = $('.errorMsgNID'); //get error message div

    var nid_length = nid_number.length;
    var tin_length = etin_number.length;

    if (identity_type == 'nid'){
        $.ajax({
            url: '/client/signup/identity-verify/nid-tin-verify',
            type: 'GET',
            data: {
                _token: $('input[name="_token"]').val(),
                nationality_type: nationality_type,
                identity_type: identity_type,
                nid_number: nid_number,
                etin_number: etin_number,
                user_DOB: user_DOB,
                g_recaptcha_response: grecaptcha.getResponse()
            },
            datatype: 'json',
            success: function (response) {
                var NIDVerificationTimeCounting = document.getElementById('NIDVerificationTimeCounting');
                if (response.success == true) {
                    if (response.status === 200) {
                        NIDVerificationTimeCounting.style.display = 'none';

                        // Put success message inside the NidTinVerificationResponse div
                        document.getElementById('NidTinVerificationResponse').innerHTML = 'Congrats!!! Your NID is valid.';

                        // Slide up NidTinVerificationResponse div and slide down the NID details div
                        $('#NidTinVerificationResponse').delay(1000).slideUp(1000, function () {
                            // NID details div slide down and put the details inside
                            // To remove the "hidden" attribute and make the element visible
                            $("#VerifiedNIDInfo").removeAttr("hidden");

                            $('#VerifiedNIDInfo').slideDown('slow');
                            document.getElementById('nid_tin_image').setAttribute('src',  response.data.photo);
                            document.getElementById('nid_tin_name').innerHTML = response.data.nameEn;
                            var nid_dob = new Date(response.data.dob);
                            document.getElementById('nid_tin_dob').innerHTML = nid_dob.getDate() + "-" + nid_dob.toLocaleString('default', {month: 'short'}) + "-" + nid_dob.getFullYear();
                            //document.getElementById('nid_gender').innerHTML = response.data.gender;

                            // Show SaveContinueBtn button
                            document.getElementById('SaveContinueBtn').classList.remove('hidden');
                            $(".reload_page").removeClass("hidden");
                        });
                    }
                }

                if (response.success == false || response.status == 'error') {
                    // Hide NIDVerificationTimeCounting div
                    NIDVerificationTimeCounting.style.display = 'none';

                    // Reset error message div and put the message inside
                    info_err.hide().empty();
                    if (response.data && response.data.response_messages && response.data.response_messages.message) {
                        info_err.removeClass('hidden').html(response.data.response_messages.message);
                    } else if (response.message) {
                        info_err.removeClass('hidden').html(response.message);
                    } else {
                        // Handle the case where neither response.data.response_messages.message nor response.message exists.
                        // You can provide a default message or handle it as needed.
                        info_err.removeClass('hidden').html('An error occurred.');
                    }


                    // Slide up NIDVerificationResponse div and slide down error message div
                    $("#NidTinVerificationResponse").slideUp('slow', function () {
                        info_err.slideDown('slow');
                    });
                    $(".errorMsgNID").removeClass("d-none");
                    $(".reload_page").removeClass("hidden");
                }

            },
            error: function (jqHR, textStatus, errorThrown) {
                // Reset error message div and put the message inside
                info_err.hide().empty();
                info_err.removeClass('hidden').html(errorThrown);

                // Slide up NIDVerificationResponse div and slide down error message div
                $("#NIDVerificationResponse").slideUp('slow', function () {
                    info_err.slideDown('slow');
                });

                // On modal close, disable NID verification calling.
                // clearTimeout(setRecursionForNIDVerification);
            },
            beforeSend: function () {
            }
        });
    }else if(identity_type == 'tin'){
        $.ajax({
            url: '/client/signup/identity-verify/tin-verify',
            type: 'GET',
            data: {
                _token: $('input[name="_token"]').val(),
                nationality_type: nationality_type,
                identity_type: identity_type,
                nid_number: nid_number,
                etin_number: etin_number,
                user_DOB: user_DOB,
                g_recaptcha_response: grecaptcha.getResponse()
            },
            datatype: 'json',
            success: function (response) {
                console.log(response);
                var NIDVerificationTimeCounting = document.getElementById('NIDVerificationTimeCounting');
                if (response.statusCode === 200) {
                    NIDVerificationTimeCounting.style.display = 'none';

                    // Put success message inside the NidTinVerificationResponse div
                    document.getElementById('NidTinVerificationResponse').innerHTML = 'Congrats!!! Your TIN is valid.';

                    // Slide up NidTinVerificationResponse div and slide down the NID details div
                    $('#NidTinVerificationResponse').delay(1000).slideUp(1000, function () {
                        // NID details div slide down and put the details inside
                        // To remove the "hidden" attribute and make the element visible
                        $("#VerifiedNIDInfo").removeAttr("hidden");

                        // $('#VerifiedNIDInfo').slideDown('slow');
                        document.getElementById('nid_tin_image').setAttribute('src',  response.data.photo);
                        // document.getElementById('nid_tin_name').setAttribute(response.data.nameEn);
                        document.getElementById('nid_tin_name').innerHTML = response.data.nameEn;
                        var nid_dob = new Date(response.data.dob);
                        document.getElementById('nid_tin_dob').innerHTML = nid_dob.getDate() + "-" + nid_dob.toLocaleString('default', {month: 'short'}) + "-" + nid_dob.getFullYear();
                        //document.getElementById('nid_gender').innerHTML = response.data.gender;

                        // Show SaveContinueBtn button
                        document.getElementById('SaveContinueBtn').classList.remove('hidden');
                        $(".reload_page").removeClass("hidden");
                    });
                }

                if (response.status === 400 || response.status === 500) {
                    // Hide NIDVerificationTimeCounting div
                    NIDVerificationTimeCounting.style.display = 'none';

                    // Reset error message div and put the message inside
                    info_err.hide().empty();
                    if (response.data.response_messages.message) {
                        info_err.removeClass('hidden').html(response.data.response_messages.message);
                    } else {
                        info_err.removeClass('hidden').html(response.message);
                    }

                    // Slide up NIDVerificationResponse div and slide down error message div
                    $("#NidTinVerificationResponse").slideUp('slow', function () {
                        info_err.slideDown('slow');
                    });

                    $(".errorMsgNID").removeClass("d-none");
                    $(".reload_page").removeClass("hidden");

                }

            },
            error: function (jqHR, textStatus, errorThrown) {
                // Reset error message div and put the message inside
                info_err.hide().empty();
                info_err.removeClass('hidden').html(errorThrown);

                // Slide up NIDVerificationResponse div and slide down error message div
                $("#NIDVerificationResponse").slideUp('slow', function () {
                    info_err.slideDown('slow');
                });

                // On modal close, disable NID verification calling.
                clearTimeout(setRecursionForNIDVerification);
            },
            beforeSend: function () {
            }
        });

    }
}

function closeModal() {
    // Clear div of NID Verification Response
    document.getElementById('NidTinVerificationResponse').innerHTML = '';

    // Reset NID info, name, gender, dob
    document.getElementById('nid_name').innerHTML = '';
    document.getElementById('nid_dob').innerHTML = '';

    // Clear div of ETIN Response count Message
    document.getElementById('ETINResponseCountMsg').innerHTML = '';
    // Reset ETIN info, name, dob
    document.getElementById('etin_name').innerHTML = '';
    document.getElementById('etin_dob').innerHTML = '';
    // Reset ETIN info, name, dob

    // Refresh the page
    // location.reload();
    $("html").css({ "overflow": "auto" });

    LoadListOfDirectors();
}

/**
 * Passport image preset info
 */
var cropper;
var canvas;
var is_passport_croped;
var image = document.getElementById('passport_upload_view');

/**
 * Passport image removed/ reset
 */
$("#passport_reset_btn").on('click', function () {

    // If already croppie initiated, then destroy it
    if (cropper) {
        cropper.destroy();
    }
    cropper = null;

    $('#passport_upload_base_code').val('');
    $('#passport_file_name').val('');
    $('#passport_upload_manual_file').val('');
    $('#passport_cropped_result').html('');
    $('#passport_upload').val('');
    $("#passport_upload_error").html('');

    $('#passport_upload_view').attr('src', '#');
    $('div.cropper-container').remove();

    document.getElementById('passport_upload_view_div').style.display = 'block';
    document.getElementById('passport_edit_btn').style.display = 'none';
    document.getElementById('passport_crop_btn').style.display = 'block';
    document.getElementById('passport_upload_view_wrapper').style.display = 'none';
    document.getElementById('passport_upload_div').style.display = 'block';
    var viewType = $('#passport_capture_div').attr('type');
    if (viewType === 'mobile') {
        document.getElementById('passport_capture_div').style.display = 'block';
    }
    $("#passport_verify").hide();
});

/**
 * Passport image edit/ resize option
 */
$("#passport_edit_btn").on('click', function () {
    $("#passport_verify").hide();
    document.getElementById('passport_cropped_result').style.display = 'none';
    document.getElementById('passport_edit_btn').style.display = 'none';
    document.getElementById('passport_upload_view_div').style.display = 'block';
    document.getElementById('passport_crop_btn').style.display = 'block';
});

/**
 * Passport image crop and set value
 */
$("#passport_crop_btn").on('click', function () {

    // If user don't crop the image then show the alert
    if (is_passport_croped == 'no') {
        swal({
            type: 'error',
            title: 'Oops...',
            text: 'Please follow the instruction shown on the right side, and position the rectangular properly to crop your proper passport image.'
        });
        return false;
    }

    document.getElementById('passport_preloader').style.display = 'block';
    document.getElementById('passport_upload_view_div').style.display = 'none';
    document.getElementById('passport_crop_btn').style.display = 'none';

    canvas = cropper.getCroppedCanvas({
        width: 1492,
        height: 2087,
    }).toDataURL('image/jpeg', 0.7); // 1.0 = image full quality
    //console.log(canvas);
    var passport_file_name = $('#passport_file_name').val();

    $('#passport_upload_base_code').val(canvas);

    document.getElementById('passport_cropped_result').style.display = 'block';
    $('#passport_cropped_result').html('');
    $('#passport_cropped_result').html('<div style="padding: 10px 15px;" class="card-header"><h5 class="card-title">File name: ' + passport_file_name + '</h5></div><div class="card-body"><img alt="Passport copy" src="' + canvas + '" /></div>');
    document.getElementById('passport_edit_btn').style.display = 'block';

    // magnify
    $('#magnify_image_large').css({ 'background-image': 'url(' + canvas + ')', 'background-repeat': 'no-repeat' });
    $('#magnify_image_small').attr('src', canvas);

    $("#passport_verify").show();

    toastr.success('Passport cropped and resized.');
    document.getElementById('passport_preloader').style.display = 'none';
});

/**
 * Passport image initialization for crop
 */
function initPassportCropper() {
    cropper = new Cropper(image, {
        viewMode: 1,
        ready: function () {
            is_passport_croped = 'no';
        },
        crop: function (e) {
            is_passport_croped = 'yes';
            //crop_data_info.textContent = JSON.stringify(cropper.getData(true));
        }
    });

    document.getElementById('passport_preloader').style.display = 'none';
}

/**
 * Passport image upload
 * @param input_data
 */
function getPassportImage(input_data) {
    if (input_data.files && input_data.files[0]) {

        $("#passport_upload_error").html('');

        // validated image height and width
        var _URL = window.URL || window.webkitURL;
        var image = new Image();
        image.src = _URL.createObjectURL(input_data.files[0]);
        image.onload = function () {
            if ((4500 < this.height || 3500 < this.width) || (1043 > this.height || 746 > this.width)) {
                $("#passport_upload_error").html('<div class="alert alert-warning fade in" role="alert"><h4>Warning! Better check yourself. </h4><p>The passport image resolution minimum <strong>746X1043</strong> pixel and maximum <strong>3500X4500</strong> pixel is suitable for verify. You have given <strong>' + this.width + 'x' + this.height + ' </strong> pixel.</p></div>');
            }
        };

        // Validate image type
        var mime_type = input_data.files[0].type;
        if (!(mime_type == 'image/jpeg' || mime_type == 'image/jpg' || mime_type == 'image/png')) {
            $("#passport_upload_error").html('<div class="alert alert-danger fade in" role="alert"><h4>Oh snap! You got an error!</h4><p>The passport format is not valid. Only PNG, JPEG, or JPG type is allowed.</p></div>');
            return false;
        }

        // validated image size
        if (!(input_data.files[0].size <= 5242880)) { // 5mb = 5242880, 1mb = 1048576
            $("#passport_upload_error").html('<div class="alert alert-danger fade in" role="alert"><h4>Oh snap! You got an error!</h4><p>The passport size maximum of 5 MB.</p></div>');
            return false;
        }

        document.getElementById('passport_upload_div').style.display = 'none';
        document.getElementById('passport_capture_div').style.display = 'none';
        document.getElementById('passport_preloader').style.display = 'block';

        var reader = new FileReader();
        reader.onload = function (e) {
            $('#passport_upload_view').attr('src', e.target.result);
            $('#passport_upload_base_code').val(e.target.result);
            $('#passport_file_name').val(input_data.files[0].name);

            // manual file
            $('#passport_upload_manual_file').val(e.target.result);

            // magnify start
            $('#magnify_image_large').css({
                'background-image': 'url(' + e.target.result + ')',
                'background-repeat': 'no-repeat'
            });
            $('#magnify_image_small').attr('src', e.target.result);
            // magnify end

            document.getElementById('passport_upload_view_wrapper').style.display = 'block';
        };
        reader.readAsDataURL(input_data.files[0]);

        setTimeout(initPassportCropper, 1000);
    }
}

function retryToPassportVerify(modal_id, reset_btn_id) {
    $(modal_id).modal('hide');
    $(reset_btn_id).trigger('click');
}

$(document).ready(function () {

    $('#passport_error_manual').on('click', function () {
        $('#PassportErrorModal').modal('hide');

        // file name
        var manual_file_name = $('#passport_file_name').val();
        var manual_file_data = $('#passport_upload_manual_file').val();
        $('#passport_file_name_show').text(manual_file_name);

        // magnify start
        $('#magnify_image_large').css({
            'background-image': 'url(' + manual_file_data + ')',
            'background-repeat': 'no-repeat'
        });
        $('#magnify_image_small').attr('src', manual_file_data);
        // magnify end

        document.getElementById('passport_upload_wrapper').style.display = 'none';
        $("#preloader").hide().html('');
        document.getElementById('passport_div_verification').style.display = 'block';
        $('#passport_verify').hide();
        $('#passport_radio').hide();
        $('#nid_tin_verify').show().text('Submit').css({ "background": "#EEEEEE", "color": "#5FB15F", "border": "1px solid #5FB15F", "border-radius": "3px" });
    });

    $('#passport_verify').on('click', function () {

        $("#preloader").show().html('<i class="fa fa-spinner fa-pulse"></i>');

        var file_data = $('#passport_upload_base_code').val(); // crop or origin image
        //var file_data = $('#passport_upload_manual_file').val(); // only origin image

        if (!file_data) {
            return false;
        }

        $.ajax({
            url: '/client/signup/getPassportData',
            type: 'POST',
            dataType: 'text',           // what to expect back from the PHP script, if anything
            data: {
                _token: $('input[name="_token"]').val(),
                file: file_data,
                photo: 'yes',
            },
            success: function (response) {
                //console.log(response);
                var obj = JSON.parse(response);

                if (obj.code == '200') {

                    document.getElementById('passport_no').value = obj.data.document_number;
                    //                            document.getElementById('passport_type').value = obj.data.document_type;
                    $("#passport_nationality").val(obj.nationality_id).change();
                    $("#passport_type").val(obj.data.document_type.toLowerCase()).change();

                    var passport_dob = new Date(obj.data.birth_date);
                    var expiry_date = new Date(obj.data.expiry_date);

                    document.getElementById('passport_surname').value = obj.data.surname;
                    document.getElementById('passport_given_name').value = obj.data.name;
                    document.getElementById('passport_personal_no').value = obj.data.optional_data;
                    document.getElementById('passport_DOB').value = passport_dob.getDate() + "-" + passport_dob.toLocaleString('default', { month: 'short' }) + "-" + passport_dob.getUTCFullYear();
                    document.getElementById('passport_date_of_expire').value = expiry_date.getDate() + "-" + expiry_date.toLocaleString('default', { month: 'short' }) + "-" + expiry_date.getUTCFullYear();

                    document.getElementById('passport_upload_wrapper').style.display = 'none';
                    $("#preloader").hide().html('');
                    document.getElementById('passport_div_verification').style.display = 'block';
                    $('#passport_verify').hide();
                    // file name
                    var pass_file_name = $('#passport_file_name').val();

                    // empty manual file
                    $('#passport_upload_manual_file').val('');

                    $('#passport_file_name_show').text(pass_file_name);
                    $('#nid_tin_verify').show().text('Submit');
                    document.getElementById('passport_logout').style.display = 'none';
                } else {
                    $("#preloader").hide().html('');
                    $('#PassportErrorModal').modal('show');
                }
            }
        });
    });

    // passport magnify
    var native_width = 0;
    var native_height = 0;
    var loadLocker = true;
    var image_object = null;

    // Now the mousemove function
    $(".magnify").mousemove(function (e) {
        if (!native_width && !native_height) {
            if (loadLocker) {
                loadLocker = false;
                image_object = new Image();
                image_object.src = $(this).children(".small").attr("src");
            }

            native_width = image_object.width;
            native_height = image_object.height;
        } else {
            var magnify_offset = $(this).offset();
            var mx = e.pageX - magnify_offset.left;
            var my = e.pageY - magnify_offset.top;

            if (mx < $(this).width() && my < $(this).height() && mx > 0 && my > 0) {
                $(this).children(".large").fadeIn(100);
            } else {
                $(this).children(".large").fadeOut(100);
            }
            if ($(this).children(".large").is(":visible")) {
                var rx = Math.round(mx / $(this).children(".small").width() * native_width - $(this).children(".large").width() / 2) * -1;
                var ry = Math.round(my / $(this).children(".small").height() * native_height - $(this).children(".large").height() / 2) * -1;
                var bgp = rx + "px " + ry + "px";
                var px = mx - $(this).children(".large").width() / 2;
                var py = my - $(this).children(".large").height() / 2;
                $(this).children(".large").css({ left: px, top: py, backgroundPosition: bgp });
            }
        }
    }).on("mouseleave", function () {
        native_width = 0;
        native_height = 0;
        loadLocker = true;
    });

});
