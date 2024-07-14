

@extends('layouts.admin')

@section('header-resources')
    <style>
        /*.bootstrap-datetimepicker-widget{*/
        /*    position: relative !important;*/
        /*    top:0 !important;*/
        /*}*/
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
    </style>
@endsection

@section('content')
    @include('partials.messages')

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-magenta border border-magenta">
                <div class="card-header" style="margin-top: -1px;">
                    <h5><strong> View Training Course </strong></h5>
                </div>
               
                <div class="card-body">

                    <div class="mb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                {!! Form::label('course_title', 'Course Name (English)', [
                                    'class' => 'col-6',
                                ]) !!}
                                    <span class="float-right">&#58;</span>
                                <div class="col-5">
                                    {{ $tr_data->course_title}}
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                {!! Form::label('course_title_bn', 'Course Name (Bangla)', [
                                    'class' => 'col-6',
                                ]) !!}
                                    <span class="float-right">&#58;</span>
                                <div class="col-5">
                                    {{ $tr_data->course_title_bn}}
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                {!! Form::label('category_id', 'Course Category', [
                                    'class' => 'col-6',
                                ]) !!}
                                    <span class="float-right">&#58;</span>
                                <div class="col-5">
                                    {{ $trCategory[$tr_data->category_id] }}
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                {!! Form::label('training_category', 'Training Category', [
                                    'class' => 'col-6',
                                ]) !!}
                                    <span class="float-right">&#58;</span>
                                <div class="col-5" id="training_category_value">
                                    {{ $tr_data->training_category}}
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="projectDiv" class="hidden">
                        <div class="mb-1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                    {!! Form::label('project_name', 'Project Name', [
                                        'class' => 'col-6',
                                    ]) !!}
                                        <span class="float-right">&#58;</span>
                                    <div class="col-5">
                                        {{ $tr_data->project_name}}
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                    {!! Form::label('project_vendor', 'Project Vendor', [
                                        'class' => 'col-6',
                                    ]) !!}
                                        <span class="float-right">&#58;</span>
                                    <div class="col-5">
                                        {{ $tr_data->project_vendor}}
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                    {!! Form::label('package_no', 'Package No.', [
                                        'class' => 'col-6',
                                    ]) !!}
                                        <span class="float-right">&#58;</span>
                                    <div class="col-5">
                                        {{  $tr_data->package_no}}
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                    {!! Form::label('lot_no', 'Lot No.', [
                                        'class' => 'col-6',
                                    ]) !!}
                                        <span class="float-right">&#58;</span>
                                    <div class="col-5">
                                        {{ $tr_data->lot_no}}
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                {!! Form::label('training_authority', 'Training Authority', [
                                    'class' => 'col-6',
                                ]) !!}
                                    <span class="float-right">&#58;</span>
                                <div class="col-5">
                                    {{$tr_data->training_authority}}
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                {!! Form::label('fund_amount', 'Fund Amount', [
                                    'class' => 'col-6',
                                ]) !!}
                                    <span class="float-right">&#58;</span>
                                <div class="col-5">
                                    {{ $tr_data->fund_amount}}
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                {!! Form::label('training_coordinator', 'Training Coordinator', [
                                    'class' => 'col-6',
                                ]) !!}
                                    <span class="float-right">&#58;</span>
                                <div class="col-5">
                                    {{ userFullName($tr_data->training_coordinator) }}
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                {!! Form::label('training_location', 'Training Location', [
                                    'class' => 'col-6',
                                ]) !!}
                                    <span class="float-right">&#58;</span>
                                <div class="col-5">
                                    {{ $tr_data->training_location}}
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                {!! Form::label('course_slug', 'Course Slug', [
                                    'class' => 'col-6',
                                ]) !!}
                                    <span class="float-right">&#58;</span>
                                <div class="col-5">
                                    {{$tr_data->course_slug}}
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                {!! Form::label('course_description', 'Course Description', [
                                    'class' => 'col-6',
                                ]) !!}
                                    <span class="float-right">&#58;</span>
                                <div class="col-5">
                                    {{ $tr_data->course_description}}
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                {!! Form::label('course_description', 'Course Description', [
                                    'class' => 'col-3',
                                ]) !!}
                                    <span class="float-right">&#58;</span>
                                <div class="col-8">
                                    {{$tr_data->course_description}}
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                {!! Form::label('course_image', 'Course image', [
                                    'class' => 'col-6',
                                ]) !!}
                                    <span class="float-right">&#58;</span>
                                <div class="col-5">
                                    <img src="{{ asset('/uploads/training/course/' . $tr_data->course_image) }}"
                                    class="img-responsive img-thumbnail course_image_thumbnail"
                                    id="course_thumbnail_preview"
                                    onerror="this.src=`{{ asset('/assets/images/photo_default.png') }}`">
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                {!! Form::label('course_image2', 'Course image 2', [
                                    'class' => 'col-6',
                                ]) !!}
                                    <span class="float-right">&#58;</span>
                                <div class="col-5">
                                    <img src="{{ asset('/uploads/training/course/' . $tr_data->course_image2) }}"
                                    class="img-responsive img-thumbnail course_image_thumbnail"
                                    id="course_thumbnail_preview2"
                                    onerror="this.src=`{{ asset('/assets/images/photo_default.png') }}`">
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                {!! Form::label('course_image3', 'Course image 3', [
                                    'class' => 'col-6',
                                ]) !!}
                                    <span class="float-right">&#58;</span>
                                <div class="col-5">
                                    <img src="{{ asset('/uploads/training/course/' . $tr_data->course_image3) }}"
                                    class="img-responsive img-thumbnail course_image_thumbnail"
                                    id="course_thumbnail_preview3"
                                    onerror="this.src=`{{ asset('/assets/images/photo_default.png') }}`">
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-left">
                                <a href="{{ url('/training/course-list') }}">
                                    {!! Form::button('<i class="fa fa-times"></i> Close', ['type' => 'button', 'class' => 'btn btn-default']) !!}
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('footer-script')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2.min.css') }}">
    <script src="{{ asset('assets/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}" type="text/javascript"></script>

    <script>
        
    document.addEventListener("DOMContentLoaded", function() {
        var trainingCategory = document.getElementById("training_category_value").textContent.trim();
        console.log(trainingCategory);
        var projectDiv = document.getElementById("projectDiv");

        if (trainingCategory === "project") {
            projectDiv.classList.remove("hidden");
        } else {
            projectDiv.classList.add("hidden");
        }
    });
</script>


@endsection
