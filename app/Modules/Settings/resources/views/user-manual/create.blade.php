@extends('layouts.admin')

@section('header-resources')
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"> {{ $card_title }} </h3>
        </div>

        {!! Form::open([
           'route' => 'user-manual.store',
            'method' => 'post',
            'id' => 'form_id',
            'enctype' => 'multipart/form-data',
            'files' => 'true',
            'role' => 'form',
        ]) !!}
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-12 {{ $errors->has('title') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('title', 'Title:', ['class' => 'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::text('title', null, ['class' => 'form-control required']) !!}
                            {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
            </div>

                <div class="form-group row">
                    {!! Form::label('document', 'Document:', ['class'=>'col-md-2 required-star']) !!}

                    <div class="col-md-10">
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input required {{ $errors->has('photo') ? ' is-invalid' : '' }}" id="document" name="document" accept="application/pdf"  onchange="updateFileName(this)">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>

                        <small class="form-text text-muted">
                            [<strong>File Format:</strong> *.pdf, <strong>File-size:</strong> 1 MB]
                        </small>

                        {!! $errors->first('document', '<span class="help-block">:message</span>') !!}


                    </div>
                </div>
            <div class="row">
                <div class="form-group  col-md-6 {{ $errors->has('status') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('status', 'Status:', ['class' => 'col-md-4 control-label required-star']) !!}

                        <div class="col-md-8">
                            <label>{!! Form::radio('status', 1, null, ['class' => 'required', 'checked']) !!}
                                Active </label>&nbsp;&nbsp;
                            <label>{!! Form::radio('status', 0, null, ['class' => 'required']) !!}
                                Inactive </label>&nbsp;&nbsp;
                            {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
            </div>


            <div class="card-footer">
                <div class="float-left">
                    <a href="{{ route('message.list') }}">
                        {!! Form::button('<i class="fa fa-times"></i> Close', ['type' => 'button', 'class' => 'btn btn-default']) !!}
                    </a>
                </div>
                <div class="float-right">
                    <button type="submit" class="btn btn-primary float-right" id="submit">
                        <i class="fa fa-chevron-circle-right"></i> Save
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
            {!! Form::close() !!}<!-- /.form end -->
        </div>
    </div>
@endsection

@section('footer-script')
    @include('partials.image-upload')
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/image_validate.js') }}"></script>

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
