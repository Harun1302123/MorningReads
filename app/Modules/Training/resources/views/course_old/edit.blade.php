

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
                            {!! Form::label('course_title', 'Course Name (English)', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('course_title') ? 'has-error' : '' }}">
                                {!! Form::text('course_title', $tr_data->course_title, ['class' => 'form-control input-md required']) !!}
                                {!! $errors->first('course_title', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6 form-group row">
                            {!! Form::label('course_title_bn', 'Course Name (Bangla)', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('course_title_bn') ? 'has-error' : '' }}">
                                {!! Form::text('course_title_bn', $tr_data->course_title_bn, ['class' => 'form-control input-md required']) !!}
                                {!! $errors->first('course_title_bn', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="col-md-6 form-group row ">
                            {!! Form::label('category_id', 'Course Category', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('category_id') ? 'has-error' : '' }}">
                                {!! Form::select('category_id', $trCategory, $tr_data->category_id, [
                                    'class' => 'form-control required imput-md',
                                    'id' => 'category_id',
                                ]) !!}
                                {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="col-md-6 form-group row">
                            {!! Form::label('training_category', 'Training Category', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('training_category') ? 'has-error' : '' }}">
                                {!! Form::select('training_category', [ 'in-house' => 'In House', 'project' => 'Project'], $tr_data->training_category, [
                                    'class' => 'form-control required',
                                    'id' => 'training_category',
                                ]) !!}
                                {!! $errors->first('training_category', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div id="projectDiv" class="{{ $tr_data->training_category === 'project' ? '' : 'hidden' }} row" >
                        <div class="col-md-6 form-group row ">
                            {!! Form::label('project_name', 'Project Name', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('project_name') ? 'has-error' : '' }}">
                                {!! Form::text('project_name', $tr_data->project_name, ['class' => 'form-control input-md required']) !!}
                                {!! $errors->first('project_name', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6 form-group row ">
                            {!! Form::label('project_vendor', 'Project Vendor', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('project_vendor') ? 'has-error' : '' }}">
                                {!! Form::text('project_vendor', $tr_data->project_vendor, ['class' => 'form-control input-md required']) !!}
                                {!! $errors->first('project_vendor', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6 form-group row ">
                            {!! Form::label('package_no', 'Package No.', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('package_no') ? 'has-error' : '' }}">
                                {!! Form::text('package_no', $tr_data->package_no, ['class' => 'form-control input-md required']) !!}
                                {!! $errors->first('package_no', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6 form-group row ">
                            {!! Form::label('lot_no', 'Lot No.', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('lot_no') ? 'has-error' : '' }}">
                                {!! Form::text('lot_no', $tr_data->lot_no, ['class' => 'form-control input-md required']) !!}
                                {!! $errors->first('lot_no', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group row ">
                            {!! Form::label('training_authority', 'Training Authority', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('training_authority') ? 'has-error' : '' }}">
                                {!! Form::text('training_authority', $tr_data->training_authority, [
                                    'class' => 'form-control input-md required',
                                ]) !!}
                                {!! $errors->first('training_authority', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="col-md-6 form-group row ">
                            {!! Form::label('source_of_fund', 'Source of Fund', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('source_of_fund') ? 'has-error' : '' }}">
                                {!! Form::text('source_of_fund', $tr_data->source_of_fund, ['class' => 'form-control input-md required']) !!}
                                {!! $errors->first('source_of_fund', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="col-md-6 form-group row ">
                            {!! Form::label('fund_amount', 'Fund Amount', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('fund_amount') ? 'has-error' : '' }}">
                                {!! Form::text('fund_amount', $tr_data->fund_amount, ['class' => 'form-control input-md required']) !!}
                                {!! $errors->first('fund_amount', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="col-md-6 form-group row ">
                            {!! Form::label('training_coordinator', 'Training Coordinator', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('training_coordinator') ? 'has-error' : '' }}">
                                {!! Form::select('training_coordinator', trainingCoordinatorList(), $tr_data->training_coordinator, [
                                    'class' => 'form-control required imput-md',
                                    'id' => 'training_coordinator',
                                ]) !!}
                                {!! $errors->first('training_coordinator', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="col-md-6 form-group row ">
                            {!! Form::label('training_location', 'Training Location', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('fund_amount') ? 'has-error' : '' }}">
                                {!! Form::text('training_location', $tr_data->training_location, ['class' => 'form-control input-md required']) !!}
                                {!! $errors->first('training_location', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="col-md-6 form-group row ">
                            {!! Form::label('course_slug', 'Course Slug', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('course_slug') ? 'has-error' : '' }}">
                                {!! Form::text('course_slug', $tr_data->course_slug, ['class' => 'form-control input-md required']) !!}
                                {!! $errors->first('course_slug', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="col-md-12 form-group row ">
                            {!! Form::label('course_description', 'Course Description', ['class' => 'col-md-2 required-star']) !!}
                            <div class="col-md-10 {{ $errors->has('course_description') ? 'has-error' : '' }}">
                                {!! Form::textarea('course_description', $tr_data->course_description, [
                                    'class' => 'form-control input-md required',
                                    'id' => 'course_description',
                                ]) !!}
                                {!! $errors->first('course_description', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group col-md-12 row">
                            {!! Form::label('course_image', 'Course image: ', ['class' => 'col-md-2 required-star']) !!}
                            <div class="col-md-6 {{ $errors->has('course_image') ? 'has-error' : '' }}">
                                {!! Form::file('course_image', [
                                    'class' => 'form-control input-md required',
                                    'id' => 'course_image',
                                    'accept' => 'image/jpeg, image/png, /image/jpg',
                                    'onclick' => 'setupImagePreview("course_image", "course_thumbnail_preview")',
                                ]) !!}
                                <small class="text-danger">N.B.: Only jpg, jpeg, png type image supported and image size
                                    must be less then 2MB</small>
                                {!! $errors->first('course_image', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="col-md-4">
                                <img src="{{ asset('/uploads/training/course/' . $tr_data->course_image) }}"
                                    class="img-responsive img-thumbnail course_image_thumbnail"
                                    id="course_thumbnail_preview"
                                    onerror="this.src=`{{ asset('/assets/images/photo_default.png') }}`">
                            </div>
                        </div>
                        <div class="form-group col-md-12 row">
                            {!! Form::label('course_image2', 'Course image 2: ', ['class' => 'col-md-2 ']) !!}
                            <div class="col-md-6 {{ $errors->has('course_image2') ? 'has-error' : '' }}">
                                {!! Form::file('course_image2', [
                                    'class' => 'form-control input-md',
                                    'id' => 'course_image2',
                                    'accept' => 'image/jpeg, image/png, /image/jpg',
                                    'onclick' => 'setupImagePreview("course_image2", "course_thumbnail_preview2")',
                                ]) !!}
                                <small class="text-danger">N.B.: Only jpg, jpeg, png type image supported and image size
                                    must be less then 2MB</small>
                                {!! $errors->first('course_image2', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="col-md-4">
                                <img src="{{ asset('/uploads/training/course/' . $tr_data->course_image2) }}"
                                    class="img-responsive img-thumbnail course_image_thumbnail"
                                    id="course_thumbnail_preview2"
                                    onerror="this.src=`{{ asset('/assets/images/photo_default.png') }}`">
                            </div>
                        </div>

                        <div class="form-group col-md-12 row">
                            {!! Form::label('course_image3', 'Course image 3: ', ['class' => 'col-md-2']) !!}
                            <div class="col-md-6 {{ $errors->has('course_image3') ? 'has-error' : '' }}">
                                {!! Form::file('course_image3', [
                                    'class' => 'form-control input-md ',
                                    'id' => 'course_image3',
                                    'accept' => 'image/jpeg, image/png, /image/jpg',
                                    'onclick' => 'setupImagePreview("course_image3", "course_thumbnail_preview3")',
                                ]) !!}
                                <small class="text-danger">N.B.: Only jpg, jpeg, png type image supported and image size
                                    must be less then 2MB</small>
                                {!! $errors->first('course_image3', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="col-md-4">
                                <img src="{{ asset('/uploads/training/course/' . $tr_data->course_image3) }}"
                                    class="img-responsive img-thumbnail course_image_thumbnail"
                                    id="course_thumbnail_preview3"
                                    onerror="this.src=`{{ asset('/assets/images/photo_default.png') }}`">
                            </div>
                        </div>

                        <div class="col-md-6 form-group row">
                            {!! Form::label('is_active', 'Active Status: ', ['class' => 'col-md-4 required-star']) !!}
                            <div class="col-md-8 {{ $errors->has('is_active') ? 'has-error' : '' }}">
                                <label>{!! Form::radio('is_active', '1', $tr_data->is_active == 1 ? 'checked' : '', [
                                    'class' => 'required',
                                    'id' => 'yes',
                                ]) !!} Active</label>
                                <label>{!! Form::radio('is_active', '0', $tr_data->is_active == 0 ? 'checked' : '', [
                                    'class' => ' required',
                                    'id' => 'no',
                                ]) !!} Inactive</label>
                                {!! $errors->first('is_active', '<span class="help-block">:message</span>') !!}
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
