@extends('layouts.admin')

@section('header-resources')

{{-- 
    ob#code@start - Harun  
     Try to minimize stylesheet in blade template
    ob#code@end - Harun
--}}

    <style>
        .analog-clock {
            width: 250px;
            height: 250px;
        }

        #clock-face {
            stroke: black;
            stroke-width: 2px;
            fill: white;
        }

        #clock-face-db {
            stroke: black;
            stroke-width: 2px;
            fill: white;
        }

        #h-hand, #m-hand, #s-hand, #s-tail, #db-h-hand, #db-m-hand, #db-s-hand, #db-s-tail {
            stroke: black;
            stroke-linecap: round;
        }

        #h-hand, #db-h-hand {
            stroke-width: 3px;
        }

        #m-hand, #db-m-hand {
            stroke-width: 2px;
        }

        #s-hand, #db-s-hand {
            stroke-width: 1px;
        }

        .time-text {
            text-align: center;
        }

        #accessList {
            height: 100px !important;
            overflow: scroll;
        }

        .dataTables_scrollHeadInner {
            width: 100% !important;
        }

        .profileinfo-table {
            width: 100% !important;
        }

        .sorting {
            background-image: url(../images/sort_both_oss.png);
        }

        label.error {
            border: none !important;
        }
    </style>
    <link rel="stylesheet"
          href="{{ asset("assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") }}"/>
    <link rel="stylesheet" href="{{ asset("assets/plugins/intlTelInput/css/intlTelInput.min.css") }}"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="{{ asset("assets/plugins/password-strength/password_strength.css") }}">
    @include('partials.datatable-css')
@endsection

@section('content')
    @include('partials.messages')
    @if(Session::has('checkProfile'))
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-danger">
                    <strong>Dear user</strong><br><br>
                    <p>We noticed that your profile setting does not complete yet 100%.<br>Please upload your <b>profile
                            picture</b>,<b>signature</b> And other required information <br>Without required filed you
                        can't
                        apply for any kind of Registration.<br><br>Thanks<br>BHTPA Authority </p>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            @if(Session::has('message'))
                <div class="alert alert-warning">
                    {{session('message')}}
                </div>
            @endif

        </div>

        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <div class="card card-info">
                    <div class="card-headerd">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab_1">
                                    {!! trans('Users::messages.profile') !!}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   data-toggle="tab"
                                   href="#tab_2"
                                ><strong>{!! trans('Users::messages.change_password') !!}</strong></a>
                            </li>

                            @if(in_array(Auth::user()->user_type, ['4x404']))

                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab"
                                       href="#tab_3"><b>{!! trans('Users::messages.delegation') !!}</b></a>
                                </li>

                            @endif

                            <li class="nav-item"><a class="nav-link" href="#tab_4" data-toggle="tab"
                                                    id="50Activities"
                                                    aria-expanded="false"><b>{!! trans('Users::messages.last_50_activities') !!}</b></a>
                            </li>

                            <li class="nav-item"><a class="nav-link" href="#tab_5" data-toggle="tab" id="accessLog"
                                                    aria-expanded="false"><b>{!! trans('Users::messages.access_log') !!}</b></a>
                            </li>

                            <li class="nav-item"><a href="#tab_6" class="nav-link" data-toggle="tab"
                                                    id="accessLogFailed"
                                                    aria-expanded="false"><b>{!! trans('Users::messages.access_log_failed') !!}</b></a>
                            </li>

                            @if(in_array(Auth::user()->user_type, ['5x505']))
                                <li class="nav-item"><a href="#tab_7" class="nav-link" data-toggle="tab"
                                                        id="companyAssociation"
                                                        aria-expanded="false"><b>{!! trans('Users::messages.companyAssociation') !!}</b></a>
                                </li>
                            @endif


                        </ul>


                    </div>

                    <div class="card-body">

                        <!-- Tab panes -->
                        <div class="tab-content">
                            {{-- tab_1 --}}
                            @include("Users::profile_update")
                            {{-- tab_2 --}}
                            @include("Users::password_change_form")
                            {{-- tab_3 --}}
                            @include("Users::process-delegation")

                            <div id="tab_4" class="container tab-pane fade">
                                <table id="last50activities"
                                       class="table table-striped table-bordered"
                                       width="100%" cellspacing="0" style="font-size: 14px;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{!! trans('Users::messages.action_taken') !!}</th>
                                        <th>{!! trans('Users::messages.ip') !!}</th>
                                        <th>{!! trans('Users::messages.date_n_time') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div id="tab_5" class="container tab-pane fade">
                                <table id="accessList" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>{!! trans('Users::messages.remote_address') !!}</th>
                                        <th>{!! trans('Users::messages.login_time') !!}</th>
                                        <th>{!! trans('Users::messages.logout_time') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            <div id="tab_6" class="container tab-pane fade">
                                <table id="accessLogFailedList" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>{!! trans('Users::messages.remote_address') !!}</th>
                                        <th>{!! trans('Users::messages.failed_login_time') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                            <div id="tab_7" class="container tab-pane fade">
                                @include("CompanyAssociation::associated-list")
                            </div>


                        </div>
                    </div>


                </div>
            </div>

        </div>

    </div>

@endsection

{{-- 
    ob#code@start - Harun  
     Try to avoid JS in blade template
    ob#code@end - Harun
--}}

@section('footer-script')
    @include('partials.datatable-js')
    @include('partials.image-upload')
    <script src="{{ asset("assets/scripts/jquery.validate.min.js") }}"></script>
    <script src="{{ asset("assets/scripts/moment.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") }}"></script>
    {{--initial- input plugin--}}
    <script src="{{ asset("assets/plugins/intlTelInput/js/intlTelInput.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/plugins/intlTelInput/js/utils.js") }}" type="text/javascript"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="{{ asset("assets/plugins/password-strength/password_strength.js") }}"></script>

    <script>


        // Show password validation check
        $(document).ready(function () {

            $("#enable_show").on("input", function () {
                var show_pass_value = document.getElementById('enable_show').value;
                checkRegularExp(show_pass_value);
            });


            // $(".delegated_user").select2({
            //     maximumSelectionLength: 1
            // });
        });

        function enableSavePassBtn() {
            var password_input_value = document.getElementById('user_new_password').value;
            checkRegularExp(password_input_value);
        }

        function checkRegularExp(password) {
            var submitbtn = $('#update_pass_btn');
            var user_password = $('#user_new_password');
            var enable_show = $('#enable_show');
            var regularExp = /^(?!\S*\s)(?=.*\d)(?=.*[~`!@#$%^&*()--+={}\[\]|\\:;"'<>,.?/_₹])(?=.*[A-Z]).{6,20}$/;

            if (regularExp.test(password) == true) {
                user_password.removeClass('is-invalid');
                user_password.addClass('is-valid');
                enable_show.removeClass('is-invalid');
                submitbtn.prop("disabled", false);
                submitbtn.removeClass("disabled");
            } else {
                enable_show.addClass('is-invalid');
                user_password.addClass('is-invalid');
                submitbtn.prop("disabled", true);
                submitbtn.addClass("disabled");
            }

        }

        $(document).ready(function ($) {
            $('#myPassword').strength_meter();
        });

        $('#myPassword').strength_meter({

            //  CSS selectors
            strengthWrapperClass: 'strength_wrapper',
            inputClass: 'strength_input',
            strengthMeterClass: 'strength_meter',
            toggleButtonClass: 'button_strength',

            // text for show / hide password links
            showPasswordText: 'Show Password',
            hidePasswordText: 'Hide Password'

        });

        function togglePasswordInfo() {
            $(".pswd_infos").toggle();
        }

        @if(Auth::user()->user_type == '5x505')
        function getCompanyAssociationList() {
            /**
             * table desk script
             * @type {jQuery}
             */
            $('#companyAssociationList').DataTable({
                processing: true,
                // serverSide: true,
                searching: false,

                ajax: {
                    url: '{{url("/client/company-association/get-company-list")}}',
                    method: 'get',
                },
                columns: [
                    {data: 'email', name: 'email'},
                    {data: 'org_nm', name: 'org_nm'},
                    {data: 'action', name: 'action'},

                ],
                "aaSorting": []
            });
        }

        function RequestCompany() {
            $.ajax({
                type: "GET",
                url: "{{ url('client/company-association/create') }}",
                dataType: "json",
                success: function (response) {
                    $('#load_content').html(response.html);
                }
            })
        }

        function deleteAssocCompany(e, key) {
            var r = confirm("Are you sure?");
            if (r !== true) {
                return false;
            }
            const button_text = e.innerText;
            const loading_sign = '...<i class="fa fa-spinner fa-spin"></i>';

            var companyAssocId = e.value;
            $.ajax({
                url: "{{ url('client/company-association/approve-reject') }}",
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    companyAssocId: companyAssocId,
                    key: key
                },
                beforeSend: function () {
                    e.innerHTML = button_text + loading_sign;
                },
                success: function (response) {
                    toastr.success('Deleted successfully!');
                    $('#companyAssociationList').DataTable().destroy();
                    getCompanyAssociationList()
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    toastr.warning('Delete not successful');
                    console.log(errorThrown);
                },
            });
        }

        $(document).ready(function () {
            getCompanyAssociationList()
        });
        @endif

        $(document).ready(function () {
            const url = document.location.toString();
            if (url.match('#')) {
                $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
            }

            $("#vreg_form").validate({
                errorPlacement: function () {
                    return false;
                }
            });

            // $('#password_change_form').validate({
            //     rules: {
            //         user_confirm_password: {
            //             equalTo: "#user_new_password"
            //         }
            //     },
            //     errorPlacement: function () {
            //         return false;
            //     }
            // });

            $( "#password_change_form" ).validate({
                rules: {
                    user_old_password: 'required',
                    user_new_password: 'required',
                    user_confirm_password: 'required',
                    user_confirm_password: {
                        equalTo: "#user_new_password"
                    }
                },
                messages: {
                    user_old_password: "Please enter your old password",
                    user_confirm_password: "Please confirm your password",
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });



            $("#delegation").validate({
                errorPlacement: function () {
                    return false;
                }

            });
            $("#update_form").validate({
                errorPlacement: function () {
                    return false;
                }
            });

            $("#division").change(function () {
                $(this).after('<span class="loading_data">Loading...</span>');
                const self = $(this);
                const districtSelectedCode = '{{ $users->district }}';
                const divisionId = $('#division').val();
                $("#loaderImg").html("<img style='margin-top: -15px;' src='<?php echo url('/public/assets/images/ajax-loader.gif'); ?>' alt='loading' />");
                $.ajax({
                    type: "GET",
                    url: "<?php echo url('/users/get-district-by-division'); ?>",
                    data: {
                        divisionId: divisionId
                    },
                    success: function (response) {
                        let option = '<option value="">Select One</option>';
                        if (response.responseCode == 1) {
                            $.each(response.data, function (id, value) {
                                if (districtSelectedCode == id.split('@')[0]) {
                                    option += '<option selected="true" value="' + id + '">' + value + '</option>';
                                } else {
                                    option += '<option value="' + id + '">' + value + '</option>';
                                }
                            });
                        }
                        $("#district").html(option);
                        $("#district").trigger('change');
                        self.next().hide();
                        $("#district").next().hide();
                    }
                });
            });
            $("#division").trigger('change');

            // get district by dstrictID
            $("#district").change(function () {
                $(this).after('<span class="loading_data">Loading...</span>');
                const self = $(this);
                const thanaSelectedCode = '{{ $users->thana }}';
                const districtId = $('#district').val();
                $("#loaderImg").html("<img style='margin-top: -15px;' src='<?php echo url('/public/assets/images/ajax-loader.gif'); ?>' alt='loading' />");
                $.ajax({
                    type: "GET",
                    url: "<?php echo url('/users/get-thana-by-district-id'); ?>",
                    data: {
                        districtId: districtId
                    },
                    success: function (response) {
                        let option = '<option value="">Select One</option>';
                        if (response.responseCode == 1) {
                            $.each(response.data, function (id, value) {
                                if (thanaSelectedCode == id.split('@')[0]) {
                                    option += '<option selected="true" value="' + id + '">' + value + '</option>';
                                } else {
                                    option += '<option value="' + id + '">' + value + '</option>';
                                }

                            });
                        }
                        $("#thana").html(option);
                        $("#thana").trigger('change');
                        self.next().hide();
                    }
                });
            });


            selectIdentityType('<?php  echo $users->identity_type; ?>');

            $("#country").change(function () {
                if (this.value == 'BD') { // 001 is country_code of Bangladesh
                    $('#division_div').removeClass('d-none');
                    $('#division').addClass('required');
                    $('#district_div').removeClass('d-none');
                    $('#district').addClass('required');
                    $('#thana_div').removeClass('d-none');
                    $('#thana').addClass('required');

                    $('#state_div').addClass('d-none');
                    $('#state').removeClass('required');
                    $('#province_div').addClass('d-none');
                    $('#province').removeClass('required');

                    $("#division").prop("disabled", false);
                    $("#district").prop("disabled", false);
                    $("#thana").prop("disabled", false);
                    $("#state").prop("disabled", true);
                    $("#province").prop("disabled", true);

                } else {
                    $('#state_div').removeClass('d-none');
                    $('#state').addClass('required');
                    $('#province_div').removeClass('d-none');
                    $('#province').addClass('required');

                    $('#division_div').addClass('d-none');
                    $('#division').removeClass('required');
                    $('#district_div').addClass('d-none');
                    $('#district').removeClass('required');
                    $('#thana_div').addClass('d-none');
                    $('#thana').removeClass('required');

                    $("#division").prop("disabled", true);
                    $("#district").prop("disabled", true);
                    $("#thana").prop("disabled", true);
                    $("#state").prop("disabled", false);
                    $("#province").prop("disabled", false);
                }
            });
            $('#country').trigger('change');

            $('.datepicker').datetimepicker({
                viewMode: 'years',
                format: 'DD-MMM-YYYY',
                // maxDate: (new Date()),
                // minDate: '01/01/1916'
            });

            let accessLogClick = 0;
            $('#accessLog').click(function () {
                accessLogClick++;
                console.log(accessLogClick);
                if (accessLogClick == 1) {
                    $('#accessList').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{url("users/get-access-log-data-for-self")}}',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                        },
                        columns: [
                            {data: 'ip_address', name: 'ip_address'},
                            {data: 'login_dt', name: 'login_dt'},
                            {data: 'logout_dt', name: 'logout_dt'},

                        ],
                        "aaSorting": []
                    });
                }
            });

            var url1 = document.location.toString();
            if (url1.match('#')) {
                if (url1.split('#')[1] == 'tab_5') {
                    $('#accessLog').trigger('click')
                }
            }

            let accessLogFailedClick = 0;
            $('#accessLogFailed').click(function () {
                accessLogFailedClick++;
                if (accessLogFailedClick == 1) {
                    $('#accessLogFailedList').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{url("users/get-access-log-failed")}}',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                        },
                        columns: [
                            {data: 'remote_address', name: 'remote_address'},
                            {data: 'created_at', name: 'created_at'}

                        ],
                        "aaSorting": []
                    });
                }
            });

            let activitiesClick = 0;
            $('#50Activities').click(function () {
                activitiesClick++;
                if (activitiesClick == 1) {
                    $('#last50activities').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {

                            url: '{{url("users/get-last-50-actions")}}',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                        },
                        columns: [
                            {data: 'rownum', name: 'rownum'},
                            {data: 'action', name: 'action'},
                            {data: 'ip_address', name: 'ip_address'},
                            {data: 'created_at', name: 'created_at'}

                        ],
                        "aaSorting": []
                    });
                }
            });

            let flag = 0;
            $('.server_date_time').on('click', function () {
                flag++;
                if (flag == 1) {
                    getAppTimeDate();
                    getTimeDate();
                }
            });

            function getTimeDate() {
                $.ajax({
                    type: 'POST',
                    url: '{{url("users/get-server-time")}}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        const options = {weekday: "long", year: "numeric", month: "long", day: "numeric"}
                        $('#db_date').html(data.db_date);
                        $('#db_time').html(data.db_time);
                        $('#app_date').html(d.toLocaleDateString("en-US", options));

                        getDbTimeDate(data.db_hour, data.db_min, data.db_sec);
                    }
                });
            }
        });

        function selectIdentityType(identity_type) {
            if (identity_type === "passport") { // 1 is for passport
                $('#passport_div').removeClass('d-none');
                $('#passport_no').addClass('required');
                $('#nid_div').addClass('d-none');
                $('#user_nid').removeClass('required');
                $('#tin_div').addClass('d-none');
                $('#brc_div').addClass('d-none');
                $('#user_tin').removeClass('required');

                $("#passport_no").prop("disabled", false);
                $("#user_nid").prop("disabled", true);
                $("#user_tin").prop("disabled", true);
            } else if (identity_type === "nid") { // 2 is for NID
                $('#passport_div').addClass('d-none');
                $('#passport_no').removeClass('required');
                $('#tin_div').addClass('d-none');
                $('#brc_div').addClass('d-none');
                $('#user_tin').removeClass('required');
                $('#nid_div').removeClass('d-none');
                $('#user_nid').addClass('required');

                $("#passport_no").prop("disabled", true);
                $("#user_tin").prop("disabled", true);
                $("#user_nid").prop("disabled", false);
            } else if (identity_type === "brc") {
                $('#passport_div').addClass('d-none');
                $('#passport_no').removeClass('required');
                $('#nid_div').addClass('d-none');
                $('#user_nid').removeClass('required');
                $('#tin_div').addClass('d-none');
                $('#user_tin').removeClass('required');
                $('#brc_div').removeClass('d-none');

                $("#passport_no").prop("disabled", true);
                $("#user_tin").prop("disabled", false);
                $("#user_nid").prop("disabled", true);
                $("#user_brc").prop("disabled", true);
            } else {
                $('#passport_div').addClass('d-none');
                $('#passport_no').removeClass('required');
                $('#nid_div').addClass('d-none');
                $('#brc_div').addClass('d-none');
                $('#user_nid').removeClass('required');
                $('#tin_div').removeClass('d-none');
                $('#user_tin').addClass('required');

                $("#passport_no").prop("disabled", true);
                $("#user_tin").prop("disabled", false);
                $("#user_nid").prop("disabled", true);
            }
        }

        function getUserDeligate() {
            const designation = $('#designation_2').val();
            $.ajax({
                url: '{{url("users/get-delegate-userinfo")}}',
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    designation: designation
                },
                dataType: 'json',
                success: function (response) {
                    let html = '<option value="">Select User</option>';
                    $.each(response, function (index, value) {
                        html += '<option value="' + value.id + '" >' + value.user_full_name + '</option>';
                    });
                    $('#delegated_user').html(html);
                },
                beforeSend: function (xhr) {
                    console.log('before send');
                },
                complete: function () {
                    //completed
                }
            });
        }

        // analog app clock
        let d = new Date();
        let hour = d.getHours();
        let min = d.getMinutes();
        let sec = d.getSeconds();

        function getAppTimeDate() {
            //calculate angle
            let h = 30 * (parseInt(hour) + parseFloat(min / 60));
            let m = 6 * min;
            let s = 6 * sec;

            //move hands
            setAttr('h-hand', h);
            setAttr('m-hand', m);
            setAttr('s-hand', s);
            setAttr('s-tail', s + 180);

            sec++;
            if (sec == 60) {
                sec = 0;
                min++;

                if (min == 60) {
                    min = 0;
                    hour++;
                }
            }

            //call every second
            setTimeout(getAppTimeDate, 1000);

        };

        //analog database clock
        function getDbTimeDate(db_hour, db_min, db_sec) {

            //calculate angle
            let db_h = 30 * (parseInt(db_hour) + parseFloat(db_min / 60));
            let db_m = 6 * db_min;
            let db_s = 6 * db_sec;
            //move hands
            setAttr('db-h-hand', db_h);
            setAttr('db-m-hand', db_m);
            setAttr('db-s-hand', db_s);
            setAttr('db-s-tail', db_s + 180);

            db_sec++;
            if (db_sec == 60) {
                db_sec = 0;
                db_min++;

                if (db_min == 60) {
                    db_min = 0;
                    db_hour++;
                }
            }

            //call every second
            //setTimeout(getDbTimeDate(db_h, db_m, db_s), 1000);
            setTimeout(function () {
                getDbTimeDate(db_hour, db_min, db_sec);
            }, 1000);

        };

        function setAttr(id, val) {
            const v = 'rotate(' + val + ', 70, 70)';
            document.getElementById(id).setAttribute('transform', v);
        }

        function setText(id, val) {
            if (val < 10) {
                val = '0' + val;
            }
            document.getElementById(id).innerHTML = val;
        }
    </script>


    <script>
        $("#user_mobile").intlTelInput({
            hiddenInput: "user_mobile",
            onlyCountries: ["bd"],
            initialCountry: "BD",
            placeholderNumberType: "MOBILE",
            separateDialCode: true,
        });
    </script>
    <script language="JavaScript">


        function take_snapshot() {

            Webcam.snap(function (data_uri) {

                $(".image-tag").val(data_uri);

                $("#my_camera").hide();

                $("#ts").hide();

                document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
                $("#results").show();
            });

        }

        $(document).ready(function () {
            $('#myPassword').strength_meter();
            $("#cameraclick").click(function () {
                Webcam.on('error', function (err) {
                    toastr.options.preventDuplicates = true;
                    toastr.error('Web camera not available on your device!');
                    $("#reset_image_from_webcamera").trigger('click');
                });

                $("#reset_image_from_webcamera").show();

                $("#camera").show();
                $("#browseimagepp").hide();

                $("#my_camera").show();

                $("#ts").show();
                $("#results").hide();

                Webcam.set({

                    width: 300,

                    height: 300,

                    image_format: 'jpeg',

                    jpeg_quality: 90

                });


                Webcam.attach('#my_camera');
            });

            $("#reset_image_from_webcamera").click(function () {
                $("#camera").hide();
                $("#browseimagepp").show();
                $("#reset_image_from_webcamera").hide();

            });


        });

    </script>
@endsection
