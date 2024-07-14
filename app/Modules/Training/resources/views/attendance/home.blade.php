<?php
if (!ACL::getAccsessRight('Training-Desk', '-A-')) {
    die('You have no access right! Please contact with system admin if you have any query.');
}
?>
@extends('layouts.admin')

@section('page_heading', trans('messages.area_form'))
@section('header-resources')
<style>
    .pe-none {
        pointer-events: none;
    }

    .course_image_thumbnail {
        height: 150px;
        width: 150px;
    }

    ul.image_checkbox_design {
        list-style-type: none;
    }

    ul.image_checkbox_design li {
        display: inline-block;
    }

    ul.image_checkbox_design li input[type="checkbox"][id^="course_thumbnail_base64"] {
        display: none;
    }

    ul.image_checkbox_design li label {
        border: 1px solid #fff;
        padding: 10px;
        display: block;
        position: relative;
        margin: 10px;
        cursor: pointer;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    ul.image_checkbox_design li label::before {
        background-color: white;
        color: white;
        content: " ";
        display: block;
        border-radius: 50%;
        border: 1px solid grey;
        position: absolute;
        top: -5px;
        left: -5px;
        width: 25px;
        height: 25px;
        text-align: center;
        line-height: 28px;
        transition-duration: 0.4s;
        transform: scale(0);
    }

    ul.image_checkbox_design li label img {
        height: 100px;
        width: 100px;
        transition-duration: 0.2s;
        transform-origin: 50% 50%;
    }

    ul.image_checkbox_design li :checked+label {
        border-color: #ddd;
    }

    ul.image_checkbox_design li :checked+label::before {
        content: "✓";
        background-color: grey;
        transform: scale(1);
    }

    ul.image_checkbox_design li :checked+label img {
        transform: scale(0.9);
        box-shadow: 0 0 5px #333;
        z-index: -1;
    }
    #list_filter label, .pagination{
        float: right;
    }
    .dataTables_empty{
        text-align: center;
    }
    .loading_data, .loading_data1{
        text-align: start;
        color: #9d9d9d;
    }
</style>
@endsection

@section('content')
    @include('partials.messages')
    <div class="row">
        <div class="col-lg-12 ">
                <div class="card card-magenta border border-magenta">
                    <div class="card-header" style="padding:13px 10px;">
                        <b> Attendance </b>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="card-body text-center">
                        <form method="POST" action="" accept-charset="UTF-8" class="form-horizontal" id="marks-info"
                            role="form" data-gtm-form-interact-id="0">
                            {!! Form::open([
                                'url' => '',
                                'method' => 'POST',
                                'accept-charset' => 'UTF-8',
                                'class' => 'form-horizontal',
                                'id' => 'marks-info',
                                'role' => 'form',
                                'data-gtm-form-interact-id' => '0',
                            ]) !!}
                            <br>
                            <div class="col-md-6 offset-md-3">

                                <div class="form-group" style="margin-bottom: 25px;">
                                    <div class="row">
                                        <div class="col-md-12 row">
                                            {!! Form::label('evaluation_date', 'Date', ['class' => 'col-md-3 text-left  required-star']) !!}
                                            <div class="col-md-9">
                                                <div class="input-group date datepicker dob_datepicker" data-target-input="nearest" id="evaluation_date">
                                                    {!! Form::text('evaluation_date', '', [
                                                        'class' => 'bigInputField form-control required calendarIcon evaluation_date',
                                                        'id' => 'evaluation_date',
                                                    ]) !!}
                                                    <div class="input-group-append" data-target="#evaluation_date"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12  row">
                                            {!! Form::label('tr_course_id', 'Course Title', ['class' => 'col-md-3 text-left required-star']) !!}
                                            <div class="col-md-9">
                                                {!! Form::select('tr_course_id', $courses, null, [
                                                    'class' => 'form-control input-md required',
                                                    'id' => 'tr_course_id',
                                                    'data-gtm-form-interact-field-id' => '1',
                                                ]) !!}
                                                <span class="loading_data" style="height: 10px; display:block"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12  row">
                                            {!! Form::label('tr_schedule_master_id', 'Batch', ['class' => 'col-md-3 text-left required-star']) !!}
                                            <div class="col-md-9">
                                                {!! Form::select('tr_schedule_master_id', ['' => 'Select Course First'], null, [
                                                    'class' => 'form-control required',
                                                    'id' => 'batch',
                                                    'data-gtm-form-interact-field-id' => '2',
                                                ]) !!}
                                                <span class="loading_data1" style="height: 10px; display:block"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12  row">
                                            {!! Form::label('tr_schedule_session_id', 'Class/Session', ['class' => 'col-md-3 text-left required-star']) !!}
                                            <div class="col-md-9">
                                                {!! Form::select('tr_schedule_session_id', ['' => 'Select Batch First'], null, [
                                                    'class' => 'form-control required',
                                                    'id' => 'classSession',
                                                    'data-gtm-form-interact-field-id' => '3',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12 col-md-offset-4">
                                <a href="{{ url('training/attendance/create') }}">
                                    <button type="button" class="btn btn-default"><i class="fa fa-times"></i>
                                        Close</button>
                                </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button type="button" class="btn btn-primary" id="filter">
                                    <i class="fa fa-filter"></i> Search
                                </button>
                                <br style="display: none;"><br>
                            </div><!-- /.box-footer -->

                            {!! Form::close() !!}
                    </div><!-- /.box -->
                </div>
                <div class="card card-magenta border border-magenta allperticipant" style="display:none">
                    <div class="card-header">
                        <b> Participants List </b>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="list" class="table table-striped table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Phone No</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list1">
                                        <!-- Dynamic content will be loaded here -->
                                    </tbody>
                                </table>
                            </div><!-- /.table-responsive -->
                    
                            <div class="text-center mt-3">
                                <a href="{{ url('training/attendance/create') }}">
                                    <button type="button" class="btn btn-default">
                                        <i class="fa fa-times"></i> Close
                                    </button>
                                </a>&nbsp;&nbsp;&nbsp;
                    
                                @if (ACL::getAccsessRight('Training-Desk', '-A-'))
                                    <button class="btn btn-success" value="PresentAll" id="presentAll" style="display: none;">
                                        Present All
                                    </button>
                                @endif
                            </div>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
                    
                </div>
        </div>
    </div>
@endsection

@section('footer-script')
    @include('partials.datatable-js')

    <link rel="stylesheet" href="{{ asset('assets/plugins/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}"> --}}
    <script src="{{ asset('assets/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css') }}"></script> --}}
    {{-- <script src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $("#tr_course_id").trigger("change");
            }, 1000);
        });

        $(document).ready(function() {
            $('.datepicker').datetimepicker({
                format: 'YYYY-MM-DD',
                maxDate: new Date()
            });

            $("#tr_course_id").change(function() {
                $("#classSession").trigger("change");
                $('#classSession').val('');
                $('.loading_data').html('Loading...');
                // $(this).after('<span class="loading_data">Loading...</span>');
                var self = $(this);
                var courseId = $('#tr_course_id').val();
                $("#loaderImg").html(
                    "<img style='margin-top: -15px;' src='<?php echo url('/public/assets/images/ajax-loader.gif'); ?>' alt='loading' />");
                $.ajax({
                    type: "GET",
                    url: "<?php echo url('/training/get-batch-by-course-id'); ?>",
                    data: {
                        courseId: courseId
                    },
                    success: function(response) {
                        var option = '<option value="">Select One</option>';
                        if (response.responseCode == 1) {
                            $.each(response.data, function(id, value) {
                                option += '<option value="' + value.id + '">' + value
                                    .batch_name + '</option>';
                            });
                        }
                        $("#batch").html(option);
                        // self.next().hide();
                        $('.loading_data').html('');
                    }
                });
            });

            $("#batch").change(function() {
                $("#classSession").trigger("change");
                $('.loading_data1').html('Loading...');
                // $(this).after('<span class="loading_data">Loading...</span>');
                var self = $(this);
                var trScheduleMasterId = $('#batch').val();
                var courseId = $('#tr_course_id').val();
                $("#loaderImg").html(
                    "<img style='margin-top: -15px;' src='<?php echo url('/public/assets/images/ajax-loader.gif'); ?>' alt='loading' />");
                $.ajax({
                    type: "GET",
                    url: "<?php echo url('/training/get-course-by-trScheduleMasterId'); ?>",
                    data: {
                        trScheduleMasterId: trScheduleMasterId,
                        courseId: courseId
                    },
                    success: function(response) {
                        var option = '<option value="">Select One</option>';
                        if (response.responseCode == 1) {
                            $.each(response.data, function(index, schedule) {
                                option += '<option value="' + schedule.id + '">' +
                                    schedule.session_name +
                                    '</option>';
                            });
                        }
                        $("#classSession").html(option);
                        // self.next().hide();
                        $('.loading_data1').html('');
                    }
                });
            });

            $("#filter").click(function() {

                var self = $(this);
                var courseId = $('#tr_course_id').val();
                var trScheduleMasterId = $('#batch').val();
                var classSessionId = $('#classSession').val();
                var attendanceDate = $('.evaluation_date').val();

                toastr.options = {
                    "positionClass": "toast-bottom-right"
                }
                if (courseId == '') {
                    toastr.error('Please fillup required fields');
                    return false;
                }

                if (attendanceDate == '') {
                    toastr.error('Please fillup required fields');
                    return false;
                }

                if (trScheduleMasterId == '') {
                    toastr.error('Please fillup required fields');
                    return false;
                }
                if (classSessionId == '') {
                    toastr.error('Please fillup required fields');
                    return false;
                }

                $('#list').DataTable().clear();
                $('#list').DataTable().destroy();

                $('#list').DataTable({
                    serverSide: true,
                    ajax: {
                        url: "{{ url('training/get-participants-by-scheduleSessionId') }}",
                        method: 'get',
                        data: {
                            trScheduleMasterId: trScheduleMasterId,
                            classSessionId: classSessionId,
                            courseId: courseId,
                            attendanceDate: attendanceDate,
                        }
                    },
                    columns: [{
                            data: 'name',
                            name: 'name',
                        },

                        {
                            data: 'mobile_no',
                            name: 'mobile_no'
                        },
                        {
                            data: 'email',
                            name: 'email',
                        },
                        {
                            data: 'status',
                            name: 'status',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            searchable: false
                        }
                    ],
                    "aaSorting": [],
                    "initComplete": function(settings, json) {
                        $(".allperticipant").slideDown();
                        var table = $('#list').DataTable();
                        var tableLength = table.rows().count();

                        if (tableLength > 0) {
                            $('#presentAll').show();
                        } else {
                            $('#presentAll').hide();
                        }
                    }
                });

            });

            $(document).on('click', '.present, .absent', function() {
                var self = $(this);
                var courseId = $('#tr_course_id').val();
                var attendanceDate = $('.evaluation_date').val();
                var trScheduleMasterId = $('#batch').val();
                var classSessionId = $('#classSession').val();
                var participantId = $(this).attr('data-id');
                var str = $(this).val();
                var result = str.split("_(")[1];
                var status = str.split("_(")[0];
                var attendId = $(this).attr('incdata');

                $.ajax({
                    type: "POST",
                    url: "<?php echo url('/training/attendance-entry'); ?>",
                    data: {
                        attendanceDate: attendanceDate,
                        classSessionId: classSessionId,
                        courseId: courseId,
                        trScheduleMasterId: trScheduleMasterId,
                        attendId: attendId,
                        participantId: result,
                        status: status
                    },
                    success: function(response) {
                        if (response.responseCode == 1) {
                            toastr.success(response.responseMessage);
                        } else {
                            toastr.error(response.responseMessage);
                        }
                        self.next().hide();
                        $('#list').DataTable().destroy();
                        $("#filter").trigger("click");
                    }
                });

            });

            $(document).on('click', '#presentAll', function() {
                $('#presentAll').prop('disabled', true);

                $("#loaderImg").html(
                    "<img style='margin-top: -15px;' src='<?php echo url('/public/assets/images/ajax-loader.gif'); ?>' alt='loading' />");
                var self = $(this);
                var courseId = $('#tr_course_id').val();
                var attendanceDate = $('.evaluation_date').val();
                var trScheduleMasterId = $('#batch').val();
                var classSessionId = $('#classSession').val();

                var attendData = [];
                $('#list tbody tr').each(function() {
                    var participantId = $(this).find('.attend').attr('data-id');
                    var str = $(this).find('.attend').val();
                    var result = str.split("_(")[1];
                    var status = str.split("_(")[0];
                    if ($(this).find('.attend').attr('incdata')) {
                        attendId = $(this).find('.attend').attr('incdata');
                    } else {
                        var attendId = '<?php echo Encryption::encodeId('0'); ?>';
                    }

                    attendData.push({
                        participantId: result,
                        attendId: attendId,
                        status: status
                    });
                });

                console.log(attendData);

                $.ajax({
                    type: "POST",
                    url: "<?php echo url('/training/attendance-entry-all'); ?>",
                    data: {
                        attendData: attendData,
                        attendanceDate: attendanceDate,
                        classSessionId: classSessionId,
                        courseId: courseId,
                        trScheduleMasterId: trScheduleMasterId,
                    },
                    success: function(response) {
                        if (response.responseCode == 1) {
                            toastr.success(response.responseMessage);
                        } else {
                            toastr.error(response.responseMessage);
                        }
                        $('#presentAll').prop('disabled', false);
                        $("#filter").trigger("click");
                    }
                });
            });

        });
    </script>
@endsection
