@extends('layouts.admin')

@section('page_heading', trans('messages.area_form'))

@section('content')
    @include('partials.messages')
    <div class="row">

        <div class="col-lg-12">
            <div class="card card-magenta border border-magenta">
                <div class="card-header" style="padding:13px 10px;">
                    <b> Notification </b>
                </div>
                <!-- /.panel-heading -->
                <div class="card-body" style="padding: 25px;">
                    <form method="POST" action="{{ url('training/notification/add-notification') }}" accept-charset="UTF-8"
                        class="form-horizontal" id="notification_info" enctype="multipart/form-data" role="form">
                        {{ csrf_field() }}
                        <br>
                        <div class="row">
                            <div class="form-group row col-md-12">
                                {!! Form::label('course_id', 'Course Name', ['class' => 'col-md-2 required-star']) !!}
                                <div class="col-md-10 {{ $errors->has('course_id') ? 'has-error' : '' }} ">
                                    {!! Form::select('course_id', $trCourse, '', ['class' => 'form-control required', 'id' => 'course_id']) !!}
                                    <span class="loading_data" style="height: 10px; display:block"></span>
                                    {!! $errors->first('course_id', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group row col-md-12">
                                {!! Form::label('batch_id', 'Batch Name', ['class' => 'col-md-2  required-star']) !!}
                                <div class="col-md-10 {{ $errors->has('batch_id') ? 'has-error' : '' }}">
                                    {!! Form::select('batch_id', [], '', [
                                        'class' => 'form-control required',
                                        'placeholder' => 'Select Batch Name',
                                        'id' => 'batch_id',
                                    ]) !!}
                                    <span class="loading_data1" style="height: 10px; display:block"></span>
                                    {!! $errors->first('batch_id', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group row col-md-12">
                                {!! Form::label('session_id', 'Class/ Session', ['class' => 'col-md-2  required-star']) !!}
                                <div class="col-md-10 {{ $errors->has('session_id') ? 'has-error' : '' }}">
                                    {!! Form::select('session_id', [], '', [
                                        'class' => 'form-control required',
                                        'placeholder' => 'Select Session',
                                        'id' => 'session_id',
                                    ]) !!}
                                    <span class="loading_data2" style="height: 10px; display:block"></span>
                                    {!! $errors->first('session_id', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group row col-md-12">
                                {!! Form::label('participant_status', 'Participant Status', ['class' => 'col-md-2  required-star']) !!}
                                <div class="col-md-10 {{ $errors->has('participant_status') ? 'has-error' : '' }}">
                                    {!! Form::select(
                                        'participant_status',
                                        ['Confirmed' => 'Confirmed', 'Declined' => 'Declined', 'All' => 'All'],
                                        'Confirmed',
                                        [
                                            'class' => 'form-control required',
                                            'placeholder' => 'Select Participant Status',
                                            'id' => 'participant_status',
                                        ],
                                    ) !!}
                                    {!! $errors->first('participant_status', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group row col-md-12">
                                {!! Form::label('subject', 'Subject', ['class' => 'col-md-2  required-star']) !!}
                                <div class="col-md-10 {{ $errors->has('subject') ? 'has-error' : '' }}">
                                    {!! Form::text('subject', '', [
                                        'class' => 'form-control required bnEng',
                                        'placeholder' => 'Subject',
                                        'id' => 'subject',
                                    ]) !!}
                                    {!! $errors->first('subject', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group row col-md-12">

                                {!! Form::label('description', 'Description', ['class' => 'col-md-2  required-star']) !!}
                                <div class="col-md-10 {{ $errors->has('description') ? 'has-error' : '' }}">
                                    {!! Form::textarea('description', '', [
                                        'class' => 'form-control tinyMce required',
                                        'id' => 'description',
                                        'rows' => 3,
                                    ]) !!}
                                    {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group row col-md-12">
                                    {!! Form::label('notify', 'Notify Via', ['class' => 'col-md-2  required-star']) !!}
                                    <div class="col-md-1 form-check form-check-inline">
                                        {!! Form::checkbox('notify_via_sms', '1', '', [
                                            'class' => 'form-check-input required',
                                            'onclick' => 'setRequireForNotify(this.id)',
                                            'id' => 'notify_via_sms',
                                        ]) !!}
                                        <label class="form-check-label" for="notify_via_sms">SMS</label>
                                    </div>
                                    <div class="col-md-1 form-check form-check-inline">
                                        {!! Form::checkbox('notify_via_email', '1', '', [
                                            'class' => 'form-check-input required',
                                            'onclick' => 'setRequireForNotify(this.id)',
                                            'id' => 'notify_via_email',
                                        ]) !!}
                                        <label class="form-check-label" for="notify_via_email">Email</label>
                                    </div>
                            </div>
                       
                        <div class="form-group row col-md-12">
                            {!! Form::label('attachmentOrUrl', 'Attachment Or Url', ['class' => 'col-md-2 ']) !!}
                            <div class="col-md-4 {{ $errors->has('attachmentOrUrl') ? 'has-error' : '' }}">
                                <label class="radio-inline">{!! Form::radio('attachmentOrUrl', 'attachment', '', [
                                    'class' => '',
                                    'onclick' => 'selectAttachmentOrUrl(this.value)',
                                ]) !!}
                                    Attachment</label>
                                <label class="radio-inline">{!! Form::radio('attachmentOrUrl', 'url', '', ['class' => '', 'onclick' => 'selectAttachmentOrUrl(this.value)']) !!}
                                    URL</label>
                            </div>
                        </div>
                        <div class="form-group row col-md-12 hidden" id="attachmentDiv">
                            <label for="attachment" class="col-md-2 ">Attractment</label>
                            <div class="col-md-10">
                                <input type="file" class="form-control" name="attachment" id="attachment"
                                    accept="application/pdf,application/doc, image/jpeg, image/png, image/jpg">
                                <small class="text-danger">N.B.: Only jpg, jpeg, png, doc, pdf type supported and
                                    max 2MB</small>
                            </div>
                        </div>
                        <div class="form-group row col-md-12 hidden" id="urlDiv">
                                
                                    <label for="url" class="col-md-2 ">URL</label>
                                    <div class="col-md-10">
                                        <input class="form-control" placeholder="Enter URL" id="url" name="url" type="url"
                                            value="">
                    
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           
        </div>
    </div>

    </div>
    <br>

    </div><!-- /.box -->

    <div class="card-footer">
        <div class="row">
            <div class="col-md-12">
                <div class="float-left">
                    <a href="{{ url('/training/notification/list') }}" style="float: left">
                        {!! Form::button('<i class="fa fa-times"></i> Close', ['type' => 'button', 'class' => 'btn btn-default']) !!}
                    </a>
                </div>
                <div class="float-right">
                    @if (ACL::getAccsessRight('Training-Desk', 'A'))
                        <button type="submit" class="btn btn-primary" id="sendEmailBtn" disabled style="float: right">
                            <i class="fa fa-chevron-circle-right"></i> <b>Submit</b>
                        </button>
                    @endif
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="clearfix"></div>

        {!! Form::close() !!}
    </div>
    </div>
    </div>

    </div>
@endsection


@section('footer-script')

    <script>
        function setRequireForNotify(id) {
            if (id == 'notify_via_sms') {
                if ($('#' + id).is(":checked") == true) {
                    $('#notify_via_email').removeClass(['required', 'error']);
                    $('#notify_via_sms').addClass('required');
                }
            }
            if (id == 'notify_via_email') {
                if ($('#' + id).is(":checked") == true) {
                    $('#notify_via_sms').removeClass(['required', 'error']);
                    $('#notify_via_email').addClass('required');
                }
            }
        }


        function selectAttachmentOrUrl(value) {
            var attachType = value;
            if (attachType == 'attachment') {
                $('#attachmentDiv').removeClass('hidden');
                $('#urlDiv').addClass('hidden');
                $('#url').val('');
            } else if (attachType == 'url') {
                $('#attachmentDiv').addClass('hidden');
                $('#urlDiv').removeClass('hidden');
                $('#attachment').val('');
            } else {
                $('#urlDiv').addClass('hidden');
                $('#attachmentDiv').addClass('hidden');
                $('#url').val('');
                $('#attachment').val('');
            }
        }

        $("#course_id").change(function() {
            // $(this).after('<span class="loading_data">Loading...</span>');
            $('.loading_data').html('Loading...');
            var self = $(this);
            var course_id = $('#course_id').val();
            $("#loaderImg").html("<img style='margin-top: -15px;' src='<?php echo url('/public/assets/images/ajax-loader.gif'); ?>' alt='loading' />");
            $.ajax({
                type: "GET",
                url: "<?php echo url('training/get-batch-by-course-id'); ?>",
                data: {
                    courseId: course_id
                },
                success: function(response) {
                    var option = '<option value="">Select One</option>';
                    if (response.responseCode == 1) {
                        $.each(response.data, function(id, value) {
                            option += '<option value="' + value.id + '">' + value.batch_name +
                                '</option>';
                        });

                    }
                    $("#batch_id").html(option);
                    // self.next().hide();
                    $('.loading_data').html('');
                }
            });
        });

        $("#batch_id").change(function() {
            // $(this).after('<span class="loading_data">Loading...</span>');
            $('.loading_data1').html('Loading...');
            var self = $(this);
            var batch_id = $('#course_id').val();
            var trScheduleMasterId = $("#batch_id").val();
            $("#loaderImg").html("<img style='margin-top: -15px;' src='<?php echo url('/public/assets/images/ajax-loader.gif'); ?>' alt='loading' />");
            $.ajax({
                type: "GET",
                url: "<?php echo url('/training/get-course-by-trScheduleMasterId'); ?>",
                data: {
                    courseId: batch_id,
                    trScheduleMasterId: trScheduleMasterId
                },
                success: function(response) {
                    console.log(response)
                    var option = '<option value="">Select One</option>';
                    if (response.responseCode == 1) {
                        console.log(response.data)
                        $.each(response.data, function(id, value) {
                            option += '<option value="' + value.id + '">' + value
                                .session_name + '</option>';
                        });
                    }
                    console.log(option)
                    $("#session_id").html(option);
                    // self.next().hide();
                    $('.loading_data1').html('');
                }
            });
        });

        $("#session_id").change(function() {
            // $(this).after('<span class="loading_data">Loading...</span>');
            $('.loading_data2').html('Loading...');
            var self = $(this);
            var session_id = $('#session_id').val();
            $("#loaderImg").html("<img style='margin-top: -15px;' src='<?php echo url('/public/assets/images/ajax-loader.gif'); ?>' alt='loading' />");
            $.ajax({
                type: "GET",
                url: "<?php echo url('/training/check-session-participant'); ?>",
                data: {
                    session_id: session_id
                },
                success: function(response) {
                    if (response.responseCode == 1) {
                        $('#sendEmailBtn').prop('disabled', false);
                    } else {
                        toastr.error("", "No participants found for the selected session!", {
                            timeOut: 6000,
                            extendedTimeOut: 1000,
                            positionClass: "toast-top-right"
                        });
                        $('#sendEmailBtn').prop('disabled', true);
                    }
                    // self.next().hide();
                    $('.loading_data2').html('');
                }
            });
        });

        $(document).ready(function() {
            $("#notification_info").validate({
                errorPlacement: function() {
                    return false;
                }
            });
        });
    </script>

    {{-- <script>
        //   tinymce.init({ selector:'#description_editor' });
        tinymce.init({
            selector: '.tinyMce',
            height: 300,
            theme: 'silver',
            plugins: [
                'autosave advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table directionality',
                'emoticons template paste textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true,
        });
    </script> --}}

@endsection <!--- footer script--->
