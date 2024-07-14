@php
   
@endphp

@extends('layouts.admin')

@section('header-resources')
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $card_title }}</h3>
        </div>
        {!! Form::open([
            'route' => 'user-manual.store',
            'method' => 'post',
            'id' => 'form_id',
            'enctype' => 'multipart/form-data',
            'files' => 'true',
            'role' => 'form',
        ]) !!}
        <!-- /.panel-heading -->
        <div class="card-body">
            <input type="hidden" name="id" value="{{ \App\Libraries\Encryption::encodeId($data->id) }}">
            <div class="row">

                <div class="form-group col-md-12 {{ $errors->has('title') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('title', 'Title:', ['class' => 'col-md-2 control-label required-star']) !!}
                        <div class="col-md-6">
                            {!! Form::text('title', $data->title, ['class' => 'form-control required']) !!}
                            {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                {!! Form::label('document', 'Document:', ['class'=>'col-md-2 required-star']) !!}

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input {{ $errors->has('document') ? ' is-invalid' : '' }}" id="document" name="document" {{ empty(optional($data)->document) ? 'required' : '' }} value="{{ optional($data)->document }}" accept="application/pdf" onchange="updateFileName(this)" >
                            <label class="custom-file-label" for="document">Choose file</label>
                        </div>
                    </div>

                    <small class="form-text text-muted">
                        [<strong>File Format:</strong> *.pdf, <strong>File-size:</strong> 1 MB]
                    </small>

                </div>
                <div class="col-md-2">
                    <a class="btn btn-info" target="_blank" href="{{ asset(($data)->document) }}"><i class="fa fa-file-image-o"></i> View Photo</a>
                </div>

            </div>
            <div class="row">
                <div class="form-group col-md-6 {{ $errors->has('status') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('status', 'Status:', ['class' => 'col-md-4 control-label required-star']) !!}
                        <div class="col-md-8">
                            <label>{!! Form::radio('status', 1, !empty($data->status == 1) ? true : false, ['class' => ' required']) !!}
                                Active </label>&nbsp;&nbsp;
                            <label>{!! Form::radio('status', 0, !empty($data->status == 0) ? true : false, ['class' => 'required']) !!}
                                Inactive </label>&nbsp;&nbsp;
                        </div>
                    </div>
                </div>
            </div>


        </div><!-- /.box -->

        <div class="card-footer">
            <div class="float-left">
                <a href="{{route($list_route)}}">
                    {!! Form::button('<i class="fa fa-times"></i> Close', ['type' => 'button', 'class' => 'btn btn-default']) !!}
                </a>
            </div>
            <div class="float-right">
                <button type="submit" class="btn btn-primary float-right">
                    <i class="fa fa-chevron-circle-right"></i> Update
                </button>
            </div>
            <div class="clearfix"></div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('footer-script')
    @include('partials.image-upload')
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/image_validate.js') }}"></script>
    <script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
    <script>
        $("#form_id").validate({
            errorPlacement: function () {
                return true;
            }
        });
        tinymce.init({
            selector: '.details',
            plugins: 'lists',
            toolbar: false,
            height: 250,

            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            },
            init_instance_callback: function(editor) {
                var freeTiny = document.querySelector('.tox .tox-notification--in');
                freeTiny.style.display = 'none';
            }
        });
        function updateFileName(input) {
            var fileName = input.files[0].name;
            var label = input.nextElementSibling;
            label.textContent = fileName;
        }
    </script>

@endsection
