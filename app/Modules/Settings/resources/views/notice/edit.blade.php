@extends('layouts.admin')

@section('header-resources')
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <style>
        .help-block{
            color: red;
        }
    </style>
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $card_title }} </h3>
        </div>
        {!! Form::open([
            'route' => 'notice.store',
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

                <div class="form-group col-md-12 {{ $errors->has('title_en') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('title_en', 'Title in English:', ['class' => 'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::text('title_en', $data->title_en, ['class' => 'form-control required']) !!}
                            {!! $errors->first('title_en', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12 {{ $errors->has('title_bn') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('title_bn', 'Title in Bangla:', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10">
                            {!! Form::text('title_bn', $data->title_bn, ['class' => 'form-control']) !!}
                            {!! $errors->first('title_bn', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12  {{ $errors->has('content_en') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('content_en', 'Content in English:', ['class' => 'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::textarea('content_en', $data->content_en, ['class' => 'form-control required details_en', 'size' => '5x3']) !!}
                            {!! $errors->first('content_en', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12  {{ $errors->has('content_bn') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('content_bn', 'Content in Bangla:', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10">
                            {!! Form::textarea('content_bn', $data->content_bn, ['class' => 'form-control details_bn', 'size' => '5x3']) !!}
                            {!! $errors->first('content_bn', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
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
            <div class="form-group row">
                {!! Form::label('image', 'Image:', ['class'=>'col-md-2 required-star']) !!}

                <div class="col-md-10">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input {{ $errors->has('image') ? ' is-invalid' : '' }}" id="image" name="image" {{ empty(optional($data)->image) ? 'required' : '' }} value="{{ optional($data)->image }}" accept="image/jpeg, image/png" onchange="previewImage(this, 'show_photo', '1', '')">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                    </div>

                    <small class="form-text text-muted">
                        [<strong>File Format:</strong> *.jpg/ .jpeg/ .png, <strong>File-size:</strong> 1 MB]
                    </small>

                    {!! $errors->first('image', '<span class="help-block">:message</span>') !!}

                    {{--Show image--}}
                    <div class="mb-1">
                        {!! CommonFunction::getImageFromURL('show_photo', optional($data)->image) !!}
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
                {!! Form::button('<i class="fa fa-chevron-circle-right"></i> Update', ['type' => 'submit', 'class' => 'btn btn-primary float-right', 'id' => 'submit']) !!}
            </div>
            <div class="clearfix"></div>
        </div>
        {!! Form::close() !!}<!-- /.form end -->
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/image_validate.js') }}"></script>
    <script>
        $("#form_id").validate({
            errorPlacement: function () {
                return true;
            }
        });
    </script>
@endsection <!--- footer script--->
