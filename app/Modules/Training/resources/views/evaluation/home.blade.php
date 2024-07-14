<?php
if (!ACL::getAccsessRight('Training-Desk', 'A')) {
    die('You have no access right! Please contact with system admin if you have any query.');
}
?>
@extends('layouts.admin')

@section('page_heading', trans('messages.area_form'))
<style>
    #list_filter label, .pagination{
        float: right;
    }
    .dataTables_empty{
        text-align: center;
    }
</style>
@section('content')
    @include('partials.messages')
    <div class="row">
        <div class="col-lg-12 ">
            <div class="card card-magenta border border-magenta">
                <div class="card-header" style="padding:13px 10px;">
                    <b> Evaluation </b>
                </div>
                <!-- /.panel-heading -->
                <div class="card-body text-center">
                    {!! Form::open([
                        'url' => '',
                        'method' => 'POST',
                        'accept-charset' => 'UTF-8',
                        'class' => 'form-horizontal',
                        'id' => 'marks-info',
                        'role' => 'form',
                    ]) !!}
                    <br>
                    <div class="col-md-6 offset-md-3">

                        <div class="form-group" style="margin-bottom: 25px;">
                            <div class="row">
                                <div class="col-md-12 row">
                                    {!! Form::label('evaluation_type', 'Marking Category', ['class' => 'col-md-3 text-left required-star']) !!}
                                    <div class="col-md-9">
                                        {!! Form::select(
                                            'evaluation_type',
                                            [
                                                '' => 'Select one',
                                                'Final Evaluation' => 'Final Evaluation',
                                            ],
                                            'Final Evaluation',
                                            ['class' => 'form-control input-md required'],
                                        ) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 25px;">
                            <div class="row">
                                <div class="col-md-12 row">
                                    {!! Form::label('evaluation_date', 'Date', ['class' => 'col-md-3 text-left required-star']) !!}
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
                                <div class="col-md-12 row">
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
                                <div class="col-md-12 row">
                                    {!! Form::label('tr_schedule_master_id', 'Batch', ['class' => 'col-md-3 text-left required-star']) !!}
                                    <div class="col-md-9">
                                        {!! Form::select('tr_schedule_master_id', [], null, [
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
                                <div class="col-md-12 row">
                                    {!! Form::label('tr_schedule_session_id', 'Class/Session', ['class' => 'col-md-3 text-left required-star']) !!}
                                    <div class="col-md-9">
                                        {!! Form::select('tr_schedule_session_id', ['' => 'Select One'], null, [
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
                        <a href="{{ url('training/evaluation/create') }}">
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
            <div class="card card-magenta border border-magenta allperticipant" style="display:none;">
                <div class="card-header">
                    <b> Participants List </b>
                </div>
                <!-- /.panel-heading -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="list" class="table table-striped table-bordered dt-responsive nowrap"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone No</th>
                                    <th>Email</th>
                                    <th>Marks</th>
                                </tr>
                            </thead>
                            <tbody id="list1">

                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->

                    @if (ACL::getAccsessRight('Training-Desk', 'A'))
                        <center>
                            <button class="btn btn-primary" type="button" id="markstAll">
                                <i class="fa fa-chevron-circle-right"></i> Submit All Marks
                            </button>
                    @endif

                    {!! Form::close() !!}<!-- /.form end -->

                </div><!-- /.panel-body -->
            </div>
        </div>
    </div>
        
@endsection


@section('footer-script')
    @include('partials.datatable-js')
    <link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}"> --}}
    <script src="{{ asset('assets/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
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
                        courseId: courseId,
                        type: 'evaluation'
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
                var attendanceDate = $('.evaluation_date').val();
                var batchId = $('#batch').val();
                var sessionId = $('#classSession').val();
                var evaluation_type = $('#evaluation_type').val();

                toastr.options = {
                    "positionClass": "toast-bottom-right"
                }
                if (evaluation_type == '') {
                    toastr.error('Please fillup required fields');
                    return false;
                }
                if (courseId == '') {
                    toastr.error('Please fillup required fields');
                    return false;
                }

                if (attendanceDate == '') {
                    toastr.error('Please fillup required fields');
                    return false;
                }

                if (batchId == '') {
                    toastr.error('Please fillup required fields');
                    return false;
                }
                if (sessionId == '') {
                    toastr.error('Please fillup required fields');
                    return false;
                }

                $('#list').DataTable().clear();
                $('#list').DataTable().destroy();

                $('#list').DataTable({
                    serverSide: true,
                    ajax: {
                        url: "{{ url('training/participants-marks') }}",
                        method: 'get',
                        data: {
                            batchId: batchId,
                            sessionId: sessionId,
                            courseId: courseId,
                            attendanceDate: attendanceDate,
                            evaluation_type: evaluation_type
                        }
                    },
                    columns: [{
                            data: 'name',
                            name: 'name',
                        },

                        {
                            data: 'moblie_no',
                            name: 'moblie_no'
                        },
                        {
                            data: 'email',
                            name: 'email',
                        },
                        {
                            data: 'marks',
                            name: 'marks',
                            searchable: false
                        }
                    ],
                    "aaSorting": [],
                    "initComplete": function(settings, json) {
                        $(".allperticipant").slideDown();
                        var table = $('#list').DataTable();
                        var tableLength = table.rows().count();
                        if (tableLength > 0) {
                            $('#markstAll').show();
                        } else {
                            $('#markstAll').hide();
                        }
                    }
                });

            });

            $(document).on('click', '#markstAll', function() {
                var marksData = [];
                $('#list tbody tr').each(function() {
                    var participantId = $(this).find('.marks').data('id');
                    var marks = $(this).find('.marks').val();
                    var evaluationId = $(this).find('.marks').attr('data-id') ? $(this).find(
                        '.marks').attr('data-id') : 0;
                    if ($(this).find('.marks').attr('id')) {
                        attendId = $(this).find('.marks').attr('id');
                    } else {
                        var attendId = '<?php echo Encryption::encodeId('0'); ?>';
                    }

                    marksData.push({
                        participantId: participantId,
                        evaluationId: attendId,
                        marks: marks
                    });
                });

                $.ajax({
                    type: "POST",
                    url: "{{ url('/training/store-participant-marks-bulk') }}",
                    data: {
                        marksData: marksData,
                        courseId: $('#tr_course_id').val(),
                        batchId: $('#batch').val(),
                        sessionId: $('#classSession').val(),
                        evaluationType: $('#evaluation_type').val(),
                        evaluationDate: $('.evaluation_date').val()

                    },
                    success: function(response) {
                        if (response.responseCode == 1) {
                            toastr.success(response.responseMessage);
                            window.location.href = "{{ url('training/evaluation/create') }}";

                        } else {
                            toastr.error(response.responseMessage);
                            $('#list').DataTable().ajax.reload();
                        }
                    }
                });
            });

        });
    </script>


@endsection <!--- footer script--->
