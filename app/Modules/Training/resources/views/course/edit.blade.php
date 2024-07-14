

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
                    <h5><strong> Edit Training Course </strong></h5>
                </div>
                {!! Form::open([
                    'url' => '/training/store-course',
                    'method' => 'post',
                    'class' => 'form-horizontal smart-form',
                    'id' => 'currency-form',
                    'enctype' => 'multipart/form-data',
                    'files' => 'true',
                    'role' => 'form',
                ]) !!}
                <div class="card-body">

                    <input type="hidden" name="app_id" value="{{ \App\Libraries\Encryption::encodeId($tr_data->id) }}" />
                    <div class="row">
                        <div class="form-group col-md-6 row">
                            {!! Form::label('course_title', 'Training Title', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('course_title') ? 'has-error' : '' }}">
                                {!! Form::text('course_title', $tr_data->course_title, ['class' => 'form-control input-md required']) !!}
                                {!! $errors->first('course_title', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6 row form-group">
                            {!! Form::label('training_organization', 'Training Organization', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('training_organization') ? 'has-error' : '' }}">
                                {!! Form::select('training_organization', $organizations, $tr_data->training_organization, [
                                    'class' => 'form-control required imput-md',
                                    'id' => 'training_organization',
                                ]) !!}
                                {!! $errors->first('training_organization', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                    </div>
                
                    <div class="row">

                        <div class="col-md-6 row form-group">
                            {!! Form::label('training_authority', 'Training Authority', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('training_authority') ? 'has-error' : '' }}">
                                {!! Form::text('training_authority', $tr_data->training_authority, ['class' => 'form-control input-md required']) !!}
                                {!! $errors->first('training_authority', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="col-md-6 row form-group">
                            {!! Form::label('training_coordinator', 'Training Coordinator', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('training_coordinator') ? 'has-error' : '' }}">
                                {!! Form::select('training_coordinator', trainingCoordinatorList(), $tr_data->training_coordinator, [
                                    'class' => 'form-control required imput-md',
                                    'id' => 'training_coordinator',
                                ]) !!}
                                {!! $errors->first('training_coordinator', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="col-md-6 row form-group">
                            {!! Form::label('training_location', 'Training Location', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('training_location') ? 'has-error' : '' }}">
                                {!! Form::text('training_location', $tr_data->training_location, ['class' => 'form-control input-md required']) !!}
                                {!! $errors->first('training_location', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6 row form-group">
                            {!! Form::label('company_name', 'Company Name', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('company_name') ? 'has-error' : '' }}">
                                {!! Form::text('company_name', $tr_data->training_company, ['class' => 'form-control input-md required']) !!}
                                {!! $errors->first('company_name', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        {{-- <div class="col-md-6 row form-group">
                            {!! Form::label('is_active', 'Active Status: ', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('is_active') ? 'has-error' : '' }}">
                                <label>{!! Form::radio('is_active', '1', ['class' => 'required', 'id' => 'yes']) !!} Active</label>
                                <label>{!! Form::radio('is_active', '0', ['class' => ' required', 'id' => 'no']) !!} Inactive</label>
                                {!! $errors->first('is_active', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div> --}}
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
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary pull-right"><i
                                        class="fa fa-chevron-circle-right"></i> Save</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection



@section('footer-script')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2.min.css') }}">
    <script src="{{ asset('assets/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $("#select2_day").select2();
            $("#speaker_id").select2();

            $(document).on('change', '#training_category', function() {
                var type = $(this).val();
                console.log(type);
                if (type == 'project') {
                    $('#projectDiv').removeClass('hidden');
                } else {
                    $('#projectDiv').addClass('hidden');
                }
            });
        });
        tinymce.init({
            selector: '#course_description'
        });

        function setupImagePreview(inputId, previewId) {
            const inputElement = document.getElementById(inputId);
            const previewElement = document.getElementById(previewId);

            inputElement.addEventListener('change', function() {
                const file = this.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        previewElement.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('Please select a valid image file.');
                    inputElement.value = ''; // Clear the input
                }
            });
        }
    </script>
@endsection
