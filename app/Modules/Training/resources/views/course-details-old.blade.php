@extends('layouts.admin')

@section('header-resources')
    <link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/intlTelInput_v16.0.8.css') }}">

    <style>
         .help_widget_new {
            height: max-content !important;
            background-color: rgba(255, 255, 255, 1);
            border: none;
            border-radius: 10px;
            position: relative;
            margin-bottom: 10px;
            padding: 10px 5px;
            box-shadow: rgba(17, 17, 26, 0.1) 0px 4px 16px, rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 56px;
            transition: all 0.3s;
        }

        .help_widget_new:hover {
            box-shadow: rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 56px, rgba(17, 17, 26, 0.1) 0px 24px 80px;
        }

        .help_widget_header img {
            width: 90%;
            margin-top: 15px;
            border-radius: 10px;
            height: auto;
            padding-top: 0 !important;
        }

        .help_widget_content {
            padding: 0 15px;
        }

        .help_widget_content h3 {
            font-weight: 600;
        }

        .help_widget_content p {
            font-size: 16px;
        }
        .course-heading{
            color: #00a65a;
        }
        .schedule-heading{
            color: #00a157;
        }
        .course-complete{
            font-size: 18px; 
            margin-bottom: 10px; 
            border-radius: 25px
        }
        .enrollment{
            margin: auto; 
            text-align:right; 
            padding: 10px 0px; 
            display: inline-block;
        }
        .navbar-laravel {
            box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
        }

        .navbar-brand,
        .nav-link,
        .my-form,
        .login-form {
            font-family: Raleway, sans-serif;
        }

        .my-form {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .my-form .row {
            margin-left: 0;
            margin-right: 0;
        }

        .login-form {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .login-form .row {
            margin-left: 0;
            margin-right: 0;
        }

        .carousel-inner img {
            width: 100%;
            height: 100%;
        }
    </style>

    <style>
        .training_course_details_sec h5 {
            margin: 0;
        }

        .training_course_details_sec .panel {
            border-radius: 5.948px;
            border: 1px solid #5FC5E0;
            background: #FFF;
            box-shadow: 0px 3.569px 9.517px 0px rgba(0, 0, 0, 0.24);
        }

        .training_course_details_sec .panel-default {
            border-color: #5FC5E0;
        }

        .training_course_details_sec .panel-body {
            padding: 0;
        }

        .training_course_details_sec .training_course_details_title {
            color: #333;
            font-size: 22px;
            font-style: normal;
        }

        .training_course_details_office span {
            color: #333;
            font-family: SolaimanLipi;
            font-size: 17.427px;
            font-style: normal;
        }

        .training_course_details_office span u {
            color: #333;
            font-family: SolaimanLipi;
            font-size: 17.427px;
            font-style: normal;
        }

        .training_course_details_sec .training_course_details_img {
            padding: 10px 12px 0 12px;
        }

        .training_course_details_sec .training_course_details_img img {
            width: 100%;
            height: 150px;
        }

        .training_course_details_text span {
            color: #333;
            font-family: SolaimanLipi;
            font-size: 20.224px;
            font-style: normal;
            font-weight: 400;
        }

        .training_course_details_text .fee {
            color: #3C763D;
        }

        .training_course_details_sec .training_course_details_data {
            padding: 0 0 0 12px;
        }


        .training_course_details_sec .training_course_details_apply,
        .training_course_details_sec .training_course_details_apply:hover {
            color: #FFFFFF !important;
            border-radius: 3.569px;
            background: #381691;
        }

        /* width */
        .training_course_description_sec ::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        .training_course_description_sec ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        .training_course_description_sec ::-webkit-scrollbar-thumb {
            border-radius: 5px;
            background: #b0b0b0;
        }

        /* Handle on hover */
        .training_course_description_sec ::-webkit-scrollbar-thumb:hover {
            background: #6d6d6d;
        }

        /** end -:- training_course_details_sec **/

        /** start -:- training_course_coordinator_sec **/

        .training_course_coordinator_sec h5 {
            color: #333;
            font-family: SolaimanLipi;
            font-size: 20.74px;
        }

        .training_course_coordinator_sec h6 {
            color: #333;
            font-family: SolaimanLipi;
            font-size: 17.994px;
            font-style: normal;
            font-weight: 700;
        }

        .training_course_coordinator_sec .panel {
            border-radius: 5.948px;
            border: 1px solid #5FC5E0;
            background: #FFF;
            box-shadow: 0px 3.569px 9.517px 0px rgba(0, 0, 0, 0.24);
        }

        .training_course_coordinator_sec .panel-body {
            padding: 0;
            height: 350px;
        }

        .training_course_coordinator_sec .course_coordinator_img_div {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .training_course_coordinator_sec .course_coordinator_img {
            height: 120px;
            width: 120px;
        }

        .training_course_coordinator_sec span {
            color: #333;
            text-align: center;
            font-family: SolaimanLipi;
            font-size: 17.399px;
            font-weight: 400;
        }


        /** end -:- training_course_venue_sec **/

        /** start -:- training_course_description_sec **/
        .training_course_description_sec {
            width: 100%;
        }

        .training_course_description_sec .panel {
            border-radius: 5.948px;
            border: 1px solid #5FC5E0;
            background: #FEFEFE;
            box-shadow: 0px 3.569px 9.517px 0px rgba(0, 0, 0, 0.24);
        }

        .training_course_description_sec .panel-body {
            padding-left: 30px;
            padding-right: 30px;
            height: 320px;
            overflow: auto;
        }

        .participant_qualifications {
            font-family: SolaimanLipi;
            font-size: 28px;
            font-weight: 700;
        }

        .outcome-details {
            color: #333;
            font-family: SolaimanLipi;
            font-size: 16.655px;
            font-style: normal;
            font-weight: 400;
        }

        .qualification-details {
            color: #333;
            font-family: Inter;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
        }

        /** end -:- training_course_description_sec **/


        /** start -:- training_course_schedule_sec **/
        .training_course_schedule_sec {
            width: 100%;
            background: white;
        }

        .training_course_schedule_sec .panel {
            border-radius: 5.948px;
            border: 1px solid #5FC5E0;
            background: #FFF;
            box-shadow: 0px 3.569px 9.517px 0px rgba(0, 0, 0, 0.24);
        }

        .training_course_schedule_sec .training_course_schedule_title {
            padding-left: 30px;
        }

        .training_course_schedule_sec .training_course_schedule_border {
            border-top: 1px solid #1329B0;
            margin-left: 30px;
            margin-right: 30px;
        }

        .training_course_schedule_sec .table-responsive {
            padding: 15px 30px 0;
        }


        .padding_top_20 {
            padding-top: 20px;
        }

        .padding_top_25 {
            padding-top: 25px !important;
        }

    </style>
@endsection
@section('content')
    @include('partials.messages')
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Registration Apply</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {!! Form::open([
                    'url' => 'training/enroll-participants/' . \App\Libraries\Encryption::encodeId($course->id),
                    'method' => 'post',
                    'class' => 'form-horizontal',
                    'id' => 'applyForm',
                    'enctype' => 'multipart/form-data',
                    'files' => true,
                    'role' => 'form',
                ]) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="isRequired" id="isRequired" />
                <input type="hidden" name="selected_file" id="selected_file" />
                <input type="hidden" name="validateFieldName" id="validateFieldName" />
                <input type="hidden" name="session_id" id="session_id" />
                <div class="modal-body">
                    <div class="modalContent">
                        <div class="form-group row">
                            <div class="col-md-6 row">
                                {!! Form::label('course_name', 'Course Name', ['class' => 'col-md-4 col-form-label']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('course_name', $course->course->course_title, [
                                        'class' => 'form-control',
                                        'id' => 'course_name',
                                        'readonly' => 'readonly',
                                    ]) !!}
                                    {!! $errors->first('course_name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-md-6 row">
                                {!! Form::label('course_location', 'Course Location', ['class' => 'col-md-4 col-form-label']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('course_location', $course->training_office, [
                                        'class' => 'form-control',
                                        'id' => 'course_location',
                                        'readonly' => 'readonly',
                                    ]) !!}
                                    {!! $errors->first('course_location', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 row">
                                {!! Form::label('course_fee', 'Course Fee', ['class' => 'col-md-4 col-form-label']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('course_fee', 0.0, [
                                        'class' => 'form-control',
                                        'id' => 'course_fee',
                                        'readonly' => 'readonly',
                                    ]) !!}
                                    {!! $errors->first('course_fee', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-md-6 row">
                                {!! Form::label('service_fee', 'Service Fee', ['class' => 'col-md-4 col-form-label']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('service_fee', 575, [
                                        'class' => 'form-control',
                                        'id' => 'service_fee',
                                        'readonly' => 'readonly',
                                    ]) !!}
                                    {!! $errors->first('service_fee', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 row">
                                {!! Form::label('name', 'Full Name', ['class' => 'col-md-4 col-form-label required-star']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 row">
                                {!! Form::label('email', 'Email', ['class' => 'col-md-4 col-form-label required-star']) !!}
                                <div class="col-md-8">
                                    {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
                                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-md-6 row">
                                {!! Form::label('dob', 'DOB', ['class' => 'col-md-4 col-form-label required-star']) !!}
                                <div class="col-md-8">

                                    <div class="input-group date datepicker dob_datepicker" id="dob"
                                        data-target-input="nearest">
                                        {!! Form::text('dob', '', [
                                            'class' => 'form-control calendarIcon required',
                                            'id' => 'dob',
                                        ]) !!}
                                        <div class="input-group-append" data-target="#dob" data-toggle="datetimepicker">
                                            <div class="input-group-text">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                        {!! $errors->first('enroll_deadline', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    {!! $errors->first('dob', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 row">
                                {!! Form::label('father_name', "Father's Name", ['class' => 'col-md-4 col-form-label required-star']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('father_name', null, ['class' => 'form-control', 'id' => 'father_name']) !!}
                                    {!! $errors->first('father_name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-md-6 row">
                                {!! Form::label('mother_name', "Mother's Name", ['class' => 'col-md-4 col-form-label required-star']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('mother_name', null, ['class' => 'form-control', 'id' => 'mother_name']) !!}
                                    {!! $errors->first('mother_name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 row">
                                {!! Form::label('mobile_no', 'Mobile No', ['class' => 'col-md-4 col-form-label required-star']) !!}
                                <div class="col-md-8">
                                    {!! Form::number('mobile_no', null, ['class' => 'form-control', 'id' => 'mobile_no']) !!}
                                    <small id="error-msg" style="display: none; color: red;">Invalid phone number.</small>
                                    {!! $errors->first('mobile_no', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-md-6 row">
                                {!! Form::label('office_address', 'Office Address', ['class' => 'col-md-4 col-form-label required-star']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('office_address', null, ['class' => 'form-control', 'id' => 'office_address']) !!}
                                    {!! $errors->first('office_address', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 row">
                                {!! Form::label('profession', 'Profession', ['class' => 'col-md-4 col-form-label required-star']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('profession', null, ['class' => 'form-control', 'id' => 'profession']) !!}
                                    {!! $errors->first('profession', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-md-6 row">
                                {!! Form::label('org_name', 'Organization Name', ['class' => 'col-md-4 col-form-label required-star']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('org_name', null, ['class' => 'form-control', 'id' => 'org_name']) !!}
                                    {!! $errors->first('org_name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" id="jobHolderDiv">
                            <div class="col-md-6 row" id="designationDiv">
                                {!! Form::label('designation', 'Designation', ['class' => 'col-md-4 col-form-label required-star']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('designation', null, ['class' => 'form-control', 'id' => 'designation']) !!}
                                    {!! $errors->first('designation', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-md-6 row">
                                {!! Form::label('attachment', 'Attachment', ['class' => 'col-md-4 col-form-label']) !!}
                                <div class="col-md-8">
                                    <input type="file" name="attachment" id="attachment" class="form-control-file"
                                        onchange="uploadDocument('preview_attachment', this.id, 'validate_field_attachment',0)">
                                    <div id="preview_attachment">
                                        <input type="hidden" value="" id="validate_field_attachment"
                                            name="validate_field_attachment">
                                    </div>
                                    <small class="text-danger">N.B.: Only jpg, jpeg, png, pdf, doc type supported (max
                                        2MB)</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <label class="center-block image-upload" for="applicant_photo">
                                    <figure>
                                        <img src="{{ asset('users/upload/' . Auth::user()->user_pic) }}"
                                            class="profile-user-img img-responsive img-circle" alt="Profile Picture"
                                            id="applicant_photo_preview" width="200"
                                            onerror="this.src=`{{ asset('/assets/images/no-image.png') }}`">
                                    </figure>
                                    <input type="hidden" id="applicant_photo_base64" name="applicant_photo_base64">
                                    <input type="hidden" id="applicant_photo_hidden" name="applicant_photo"
                                        value="{{ Auth::user()->user_pic }}">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer w-100">
                    <button type="button" class="btn btn-secondary float-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="container my-4">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="training_course_details_sec">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="training_course_details_img">
                                        <figure>
                                            <img src="{{ asset('uploads/training/course/' . $course->course_thumbnail_path) }}"
                                                class="img-responsive img-rounded" alt="..."
                                                onerror="this.src=`{{ asset('/assets/images/photo_default.png') }}`">
                                        </figure>
                                    </div>
                                    <div class="training_course_details_data">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="training_course_details_title">
                                                    {{ $course->course->course_title }}</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="training_course_details_office pt-4 pb-2">
                                                    <span>Office Name :
                                                        <u>{{ $course->venue }}</u></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5 class="training_course_details_text py-1">
                                                    <span>Orientation</span>
                                                    <span>{{ date('d M Y', strtotime($course->course_duration_start)) }}</span>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5 class="training_course_details_text">
                                                    <span>Class Start:</span>
                                                    <span>{{ date('d M Y', strtotime($course->course_duration_start)) }}</span>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5 class="training_course_details_text py-1">
                                                    <?php
                                                    $enroll_deadline = strtotime($course->enroll_deadline);
                                                    $current_date = strtotime(date('Y-m-d'));
                                                    ?>
                                                    @if ($enroll_deadline >= $current_date)
                                                        <span>Registration Ends:</span>
                                                        <span>{{ date('d M Y', strtotime($course->enroll_deadline)) }}</span>
                                                    @else
                                                        <span class="text-danger">Registration Closed</span>
                                                    @endif
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5 class="training_course_details_text">
                                                    <span class="fee"> Fee:</span>
                                                    <span
                                                        class="fee">{{ $course->fees_type == 'paid' ? $course->amount . ' Taka' : 'FREE' }}</span>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="padding_top_20"></div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div><!--./training_course_details_sec-->
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="training_course_coordinator_sec my-3">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 text-center pt-4">
                                            <h5>Course Coordinator</h5>
                                        </div>
                                    </div>
                                    <div class="row py-3">
                                        <div class="col-md-12 text-center course_coordinator_img_div">
                                            <img src="{{ asset('users/profile-pic/' . $course->coordinator->user_pic) }}"
                                                class="rounded-circle" alt="..." style="height: 144px">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <h6>{{ $course->coordinator->user_first_name ?? '' }}</h6>
                                            <span>{{ $course->coordinator->designation ?? '' }}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <span>Mobile : </span><span
                                                class="input_ban">{{ $course->coordinator->user_mobile ?? '' }}</span>
                                            <br>
                                            <span>Email :
                                            </span><span>{{ $course->coordinator->user_email ?? '' }}</span>

                                        </div>
                                    </div>
                                    <div class="padding_top_25"></div>
                                </div>
                            </div>
                        </div><!--./training_course_details_sec-->
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

                <div class="row">
                    <div class="col-md-12">
                        <div class="training_course_description_sec">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 participant_qualifications pt-4">
                                            <h3>Pre qualifications of Participant</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 qualification-details">
                                            {!! $course->necessary_qualification_experience ? $course->necessary_qualification_experience : 'Not Needed' !!}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 participant_qualifications">
                                            <h3>Training Outlines and Outcomes</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 outcome-details">
                                            {!! $course->objectives !!}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div><!--./training_course_description_sec-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="training_course_schedule_sec mt-3">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="training_course_schedule_title  participant_qualifications pt-4">
                                                <h3>Class Schedule</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="training_course_schedule_border"></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 30%;" class="">Day</th>
                                                            <th style="width: 30%;" class="">Time</th>
                                                            <th style="width: 10%;" class="">Location</th>
                                                            <th style="width: 20%;" class="">Available Seat</th>
                                                            @if (
                                                                $course->enroll_deadline >= \Carbon\Carbon::now()->subDay() &&
                                                                    !checkUserTrainingDesk() &&
                                                                    Auth::user()->user_type != '1x101')
                                                                <th class="text-center">Action</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($scheduleSession as $row)
                                                            <tr>
                                                                <td style="width: 25%" class="">
                                                                    <span>{{ $row->session_days }}</span>
                                                                </td>
                                                                <td style="width: 25%" class="">
                                                                    <span>{{ date('h:i a', strtotime($row->session_start_time)) }}
                                                                        -
                                                                        {{ date('h:i a', strtotime($row->session_end_time)) }}</span>
                                                                </td>
                                                                <td style="width: 25%;" class=" input_ban">
                                                                    {{ $course->venue ?? '' }}

                                                                </td>
                                                                <td style="width: 25%;" class=" input_ban">
                                                                    {{ $row->seat_capacity == 0 ? 'Unlimited' : $row->seat_capacity }}
                                                                </td>
                                                                <td>
                                                                    @if (
                                                                        $course->enroll_deadline >= date('Y-m-d') &&
                                                                            $course->status == 'upcoming' &&
                                                                            !checkUserTrainingDesk() &&
                                                                            Auth::user()->user_type != '1x101')
                                                                        @if (checkSeatAbility($course->id, $row->id))
                                                                            <button type="button"
                                                                                class="btn btn-primary apply_course"
                                                                                data-toggle="modal" data-target="#myModal"
                                                                                id="{{ \App\Libraries\Encryption::encodeId($row->id) }}"
                                                                                onclick="updateSessionID(this.id)">
                                                                                Apply
                                                                            </button>
                                                                        @else
                                                                            <p class="text-danger">Seat Full</p>
                                                                        @endif
                                                                    @endif
                                                                    <!-- Button trigger modal -->
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--./training_course_schedule_sec-->
                    </div><!--./col-md-12 (Course Schedule)-->
                </div><!--./row (Course Schedule)-->
            </div><!-- ./col-lg-8 col-md-8 col-sm-12 col-xs-12 -->
        </div><!-- ./row (main)-->
        <!-- start -:- Suggestion Course -->
    </div><!-- ./container (main)-->
@endsection

@section('footer-script')
    <script src="{{ asset('assets/scripts/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/intlTelInput-jquery_v16.0.8.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/utils_v16.0.8.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('.datepicker').datetimepicker({
                format: 'YYYY-MM-DD',
                minDate: '01/01/1905',
            });
            $("#applyForm").validate({
                errorPlacement: function() {
                    return false;
                }
            })

            $(document).ready(function() {
                var input = $("#mobile_no");
                var errorMsg = $("#error-msg");

                // Initialize the intlTelInput plugin
                var iti = input.intlTelInput({
                    hiddenInput: "mobile_no",
                    initialCountry: "BD",
                    placeholderNumberType: "MOBILE",
                    separateDialCode: true
                });

                input.on('blur', function() {
                    if (input.intlTelInput("isValidNumber")) {
                        errorMsg.hide();
                        input.removeClass('error');
                    } else {
                        errorMsg.show();
                        input.addClass('error');
                    }
                });

                // Optionally, validate on keyup or change
                input.on('keyup change', function() {
                    if (input.intlTelInput("isValidNumber")) {
                        errorMsg.hide();
                        input.removeClass('error');
                    } else {
                        errorMsg.show();
                        input.addClass('error');
                    }
                });

            });

            $(".apply_course").click(function() {
                var session_id = $(this).attr('data-id');
                $("#session_id").val(session_id);

                $.ajax({
                    method: 'GET',
                    url: "/training/check-seat-capacity",
                    data: {
                        session_id: session_id
                    },
                    success: function(response) {
                        if (response.responseCode == false) {
                            toastr.error('Their is no seat available for this session');
                        } else {
                            $('#applyModal').modal('show');
                        }
                    }
                });
            });
        })

        function uploadDocument(targets, id, vField, isRequired) {

            var inputFile = $("#" + id).val();
            if (inputFile == '') {
                $("#" + id).html('');
                document.getElementById("isRequired").value = '';
                document.getElementById("selected_file").value = '';
                document.getElementById("validateFieldName").value = '';
                document.getElementById(targets).innerHTML = '<input type="hidden" class="required" value="" id="' +
                    vField + '" name="' + vField + '">';
                if ($('#label_' + id).length)
                    $('#label_' + id).remove();
                return false;
            }
            document.getElementById("isRequired").value = isRequired;
            document.getElementById("selected_file").value = id;
            document.getElementById("validateFieldName").value = vField;
            document.getElementById(targets).style.color = "red";
            var action = "{{ url('/training/upload-document') }}";
            $("#" + targets).html('Uploading....');
            var file_data = $("#" + id).prop('files')[0];
            var form_data = new FormData();
            form_data.append('selected_file', id);
            form_data.append('isRequired', isRequired);
            form_data.append('validateFieldName', vField);
            form_data.append('_token', "{{ csrf_token() }}");
            form_data.append(id, file_data);
            $.ajax({
                target: '#' + targets,
                url: action,
                dataType: 'text', // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(response) {

                    $('#' + targets).html(response);
                    var fileNameArr = inputFile.split("\\");
                    var l = fileNameArr.length;
                    if ($('#label_' + id).length)
                        $('#label_' + id).remove();
                    var doc_id = id;
                    var newInput = $('<label class="saved_file_' + doc_id + '" id="label_' + id +
                        '"><br/><b>File: ' + fileNameArr[l - 1] + '</b></label>');
                    //                        var newInput = $('<label id="label_' + id + '"><br/><b>File: ' + fileNameArr[l - 1] + '</b></label>');
                    $("#" + id).after(newInput);
                    $('#' + id).removeClass('required');
                    //check valid data
                    document.getElementById(id).value = '';
                    var validate_field = $('#' + vField).val();
                    if (validate_field == '') {
                        document.getElementById(id).value = '';
                    }
                }
            });

        }

        function updateSessionID(id) {
            document.getElementById('session_id').value = id;
        }
    </script>
@endsection <!--- footer-script--->
