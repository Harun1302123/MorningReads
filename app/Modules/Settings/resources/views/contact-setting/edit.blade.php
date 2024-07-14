@extends('layouts.admin')

@section('header-resources')
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $card_title }} </h3>
        </div>
        {!! Form::open([
            'route' => 'contact-setting.store',
            'method' => 'post',
            'id' => 'form_id',
            'enctype' => 'multipart/form-data',
            'files' => 'true',
            'role' => 'form',
        ]) !!}
        <!-- /.panel-heading -->
        <div class="card-body">
            <input type="hidden" name="id" value="{{ \App\Libraries\Encryption::encodeId($data->id) }}">
            <div class="card card-cyan border border-magenta">
                <div class="card-header section_heading1" style="padding:0.35rem 1.25rem">
                    <h3 class="card-title pt-2 pb-2"> General Information </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div
                            class="form-group col-md-12 {{ $errors->has('contact_person_one_name_en') ? 'has-error' : '' }}">
                            <div class="row">
                                {!! Form::label('contact_person_one_name_en', 'Contact Person  Name :', [
                                    'class' => 'col-md-4 control-label',
                                ]) !!}
                                <div class="col-md-8">
                                    {!! Form::text('contact_person_one_name_en', $data->contact_person_one_name_en, ['class' => 'form-control']) !!}
                                    {!! $errors->first('contact_person_one_name_en', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        {{--<div class="form-group col-md-12 {{ $errors->has('contact_person_one_name_bn') ? 'has-error' : '' }}">
                            <div class="row">
                                {!! Form::label('contact_person_one_name_bn', 'Contact Person  Name:', [
                                    'class' => 'col-md-4 control-label',
                                ]) !!}
                                <div class="col-md-8">
                                    {!! Form::text('contact_person_one_name_bn', $data->contact_person_one_name_bn, ['class' => 'form-control']) !!}
                                    {!! $errors->first('contact_person_one_name_bn', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>--}}
                        <div class="form-group col-md-12 {{ $errors->has('contact_person_one_phone') ? 'has-error' : '' }}">
                            <div class="row">
                                {!! Form::label('contact_person_one_phone', 'Contact Person Phone:', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('contact_person_one_phone', $data->contact_person_one_phone, ['class' => 'form-control']) !!}
                                    {!! $errors->first('contact_person_one_phone', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('contact_person_one_email') ? 'has-error' : '' }}">
                            <div class="row">
                                {!! Form::label('contact_person_one_email', 'Contact Person Email:', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('contact_person_one_email', $data->contact_person_one_email, ['class' => 'form-control']) !!}
                                    {!! $errors->first('contact_person_one_email', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div
                            class="form-group col-md-12 {{ $errors->has('contact_person_one_location') ? 'has-error' : '' }}">
                            <div class="row">
                                {!! Form::label('contact_person_one_location', 'Contact Person location:', [
                                    'class' => 'col-md-4 control-label',
                                ]) !!}
                                <div class="col-md-8">
                                    {!! Form::text('contact_person_one_location', $data->contact_person_one_location, ['class' => 'form-control']) !!}
                                    {!! $errors->first('contact_person_one_location', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-cyan border border-magenta">
                <div class="card-header section_heading1" style="padding:0.35rem 1.25rem">
                    <h3 class="card-title pt-2 pb-2"> Technical support </h3>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="form-group col-md-12 {{ $errors->has('contact_person_two_name_en') ? 'has-error' : '' }}">
                            <div class="row">
                                {!! Form::label('contact_person_two_name_en', 'Contact Person Name :', [
                                    'class' => 'col-md-4 control-label',
                                ]) !!}
                                <div class="col-md-8">
                                    {!! Form::text('contact_person_two_name_en', $data->contact_person_two_name_en, ['class' => 'form-control']) !!}
                                    {!! $errors->first('contact_person_two_name_en', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    {{--    <div
                            class="form-group col-md-12 {{ $errors->has('contact_person_two_name_bn') ? 'has-error' : '' }}">
                            <div class="row">
                                {!! Form::label('contact_person_two_name_bn', 'Contact Person  Name BN:', [
                                    'class' => 'col-md-4 control-label',
                                ]) !!}
                                <div class="col-md-8">
                                    {!! Form::text('contact_person_two_name_bn', $data->contact_person_two_name_bn, ['class' => 'form-control']) !!}
                                    {!! $errors->first('contact_person_two_name_bn', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>--}}
                        <div
                            class="form-group col-md-12 {{ $errors->has('contact_person_two_phone') ? 'has-error' : '' }}">
                            <div class="row">
                                {!! Form::label('contact_person_two_phone', 'Contact Person Phone:', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('contact_person_two_phone', $data->contact_person_two_phone, ['class' => 'form-control']) !!}
                                    {!! $errors->first('contact_person_two_phone', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div
                            class="form-group col-md-12 {{ $errors->has('contact_person_two_email') ? 'has-error' : '' }}">
                            <div class="row">
                                {!! Form::label('contact_person_two_email', 'Contact Person Email:', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('contact_person_two_email', $data->contact_person_two_email, ['class' => 'form-control']) !!}
                                    {!! $errors->first('contact_person_two_email', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div
                            class="form-group col-md-12 {{ $errors->has('contact_person_two_location') ? 'has-error' : '' }}">
                            <div class="row">
                                {!! Form::label('contact_person_two_location', 'Contact Person Location:', [
                                    'class' => 'col-md-4 control-label',
                                ]) !!}
                                <div class="col-md-8">
                                    {!! Form::text('contact_person_two_location', $data->contact_person_two_location, ['class' => 'form-control']) !!}
                                    {!! $errors->first('contact_person_two_location', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-cyan border border-magenta">
                <div class="card-header section_heading1" style="padding:0.35rem 1.25rem">
                    <h3 class="card-title pt-2 pb-2"> Contact regarding software </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12 {{ $errors->has('contact_person_three_name_en') ? 'has-error' : '' }}">
                            <div class="row">
                                {!! Form::label('contact_person_three_name_en', 'Contact Person  Name:', [
                                    'class' => 'col-md-4 control-label',
                                ]) !!}
                                <div class="col-md-8">
                                    {!! Form::text('contact_person_three_name_en', $data->contact_person_three_name_en, ['class' => 'form-control']) !!}
                                    {!! $errors->first('contact_person_three_name_en', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        {{--<div class="form-group col-md-12 {{ $errors->has('contact_person_three_name_bn') ? 'has-error' : '' }}">
                            <div class="row">
                                {!! Form::label('contact_person_three_name_bn', 'Contact Person  Name:', [
                                    'class' => 'col-md-4 control-label',
                                ]) !!}
                                <div class="col-md-8">
                                    {!! Form::text('contact_person_three_name_bn', $data->contact_person_three_name_bn, ['class' => 'form-control']) !!}
                                    {!! $errors->first('contact_person_three_name_bn', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>--}}
                        <div class="form-group col-md-12 {{ $errors->has('contact_person_three_designation_en') ? 'has-error' : '' }}">
                            <div class="row">
                                {!! Form::label('contact_person_three_designation_en', 'Contact Person  Designation:', [
                                    'class' => 'col-md-4 control-label',
                                ]) !!}
                                <div class="col-md-8">
                                    {!! Form::text('contact_person_three_designation_en', $data->contact_person_three_designation_en, [
                                        'class' => 'form-control',
                                    ]) !!}
                                    {!! $errors->first('contact_person_three_designation_en', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        {{--<div class="form-group col-md-12 {{ $errors->has('contact_person_three_designation_bn') ? 'has-error' : '' }}">
                            <div class="row">
                                {!! Form::label('contact_person_three_designation_bn', 'Contact Person  Designation BN:', [
                                    'class' => 'col-md-4 control-label',
                                ]) !!}
                                <div class="col-md-8">
                                    {!! Form::text('contact_person_three_designation_bn', $data->contact_person_three_designation_bn, [
                                        'class' => 'form-control',
                                    ]) !!}
                                    {!! $errors->first('contact_person_three_designation_bn', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>--}}
                        <div class="form-group col-md-12 {{ $errors->has('contact_person_three_phone') ? 'has-error' : '' }}">
                            <div class="row">
                                {!! Form::label('contact_person_three_phone', 'Contact Person Phone:', [
                                    'class' => 'col-md-4 control-label',
                                ]) !!}
                                <div class="col-md-8">
                                    {!! Form::text('contact_person_three_phone', $data->contact_person_three_phone, ['class' => 'form-control']) !!}
                                    {!! $errors->first('contact_person_three_phone', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('contact_person_three_email') ? 'has-error' : '' }}">
                            <div class="row">
                                {!! Form::label('contact_person_three_email', 'Contact Person Email:', [
                                    'class' => 'col-md-4 control-label',
                                ]) !!}
                                <div class="col-md-8">
                                    {!! Form::text('contact_person_three_email', $data->contact_person_three_email, ['class' => 'form-control']) !!}
                                    {!! $errors->first('contact_person_three_email', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.box -->

        <div class="card-footer">
            <div class="float-left">
                <a href="{{ route($list_route) }}">
                    {!! Form::button('<i class="fa fa-times"></i> Close', ['type' => 'button', 'class' => 'btn btn-default']) !!}
                </a>
            </div>
            <div class="float-right">
                {!! Form::button('<i class="fa fa-chevron-circle-right"></i> Update', [
                    'type' => 'submit',
                    'class' => 'btn btn-primary float-right',
                    'id' => 'submit',
                ]) !!}
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
            errorPlacement: function() {
                return true;
            }
        });
    </script>
@endsection <!--- footer script--->
