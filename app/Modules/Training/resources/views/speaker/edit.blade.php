@extends('layouts.admin')

@section('page_heading', trans('messages.rollback'))

@section('content')

    <div class="row">
        @include('partials.messages')
        <div class="col-lg-12">
            <div class="card card-magenta border border-magenta">
                <div class="card-header" style="margin-top: -1px;">
                    <h5><strong> Edit Training Speaker </strong></h5>
                </div>
                {!! Form::open([
                    'url' => '/training/store-speaker',
                    'method' => 'post',
                    'class' => 'form-horizontal smart-form',
                    'id' => 'speakerForm',
                    'enctype' => 'multipart/form-data',
                    'files' => 'true',
                    'role' => 'form',
                ]) !!}

                <input type="hidden" name="app_id" value="{{ \App\Libraries\Encryption::encodeId($tr_data->id) }}" />
                <div class="card-body row">
                    <div class="col-md-6 form-group row">
                        {!! Form::label('speaker_name', 'Speaker Name', ['class' => 'col-md-4 required-star control-label']) !!}
                        <div class="col-md-8 {{ $errors->has('speaker_name') ? 'has-error' : '' }}">
                            {!! Form::text('speaker_name',$tr_data->speaker_name, [
                                'class' => 'form-control calendarIcon required',
                                'id' => 'speaker_name',
                            ]) !!}
                            {!! $errors->first('speaker_name', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="col-md-6 form-group row">
                        {!! Form::label('gender', 'Gender', ['class' => 'col-md-4 control-label required-star']) !!}
                        <div class="col-md-8 {{ $errors->has('gender') ? 'has-error' : '' }}">
                            <label class="form-check-label radio-inline mx-4">
                                {!! Form::radio('gender', 'male', $tr_data->gender == 'male', [
                                    'class' => 'form-check-input gender',
                                ]) !!}
                                Male
                            </label>
                            <label class="form-check-label radio-inline">
                                {!! Form::radio('gender', 'female', $tr_data->gender == 'false', [
                                    'class' => 'form-check-input gender',
                                ]) !!}
                                Female
                            </label>
                            {!! $errors->first('gender', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="col-md-6 form-group row">
                        {!! Form::label('speaker_email', 'Speaker Email', ['class' => 'col-md-4 control-label required-star']) !!}
                        <div class="col-md-8  {{ $errors->has('speaker_email') ? 'has-error' : '' }}">
                            {!! Form::text('speaker_email', $tr_data->speaker_email, [
                                'class' => 'form-control input-md required ',
                                'id' => 'speaker_email',
                            ]) !!}
                            {!! $errors->first('speaker_email', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-md-6 form-group row">
                        {!! Form::label('speaker_mobile', 'Speaker Mobile No', ['class' => 'col-md-4 control-label required-star']) !!}
                        <div class="col-md-8 {{ $errors->has('speaker_mobile') ? 'has-error' : '' }}">
                            {!! Form::input('text', 'speaker_mobile', $tr_data->speaker_mobile, [
                                'class' => 'form-control input-md required  onlyNumber',
                                'id' => 'speaker_mobile',
                            ]) !!}
                            {!! $errors->first('speaker_mobile', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-md-6 form-group row">
                        {!! Form::label('designation', 'Designation', ['class' => 'col-md-4 control-label required-star']) !!}
                        <div class="col-md-8 {{ $errors->has('designation') ? 'has-error' : '' }}">
                            {!! Form::input('text', 'designation', $tr_data->designation, [
                                'class' => 'form-control input-md required bnEng',
                                'id' => 'designation',
                                'placeholder' => 'designation',
                            ]) !!}
                            {!! $errors->first('designation', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-md-6 mt-10 form-group row">
                        {!! Form::label('organization', 'Organization', ['class' => 'col-md-4 control-label required-star']) !!}
                        <div class="col-md-8 {{ $errors->has('organization') ? 'has-error' : '' }}">
                            {!! Form::input('text', 'organization', $tr_data->organization, [
                                'class' => 'form-control input-md required',
                                'id' => 'organization',
                            ]) !!}
                            {!! $errors->first('organization', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-md-6 form-group row">
                        {!! Form::label('district', "District", ['class' => 'col-md-4 control-label required-star']) !!}
                        <div class="col-md-8  {{ $errors->has('district') ? 'has-error' : '' }}">
                            {!! Form::select('district', ['Option1' => 'Dhaka', 'Option2' => 'Rajshahi'], null, [
                                'class' => 'form-control input-md required',
                                'id' => 'district',
                            ]) !!}
                            {!! $errors->first('district', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-md-6 mt-10 form-group row">
                        {!! Form::label('thana', 'Thana/Upzilla', ['class' => 'col-md-4 control-label required-star']) !!}
                        <div class="col-md-8  {{ $errors->has('thana') ? 'has-error' : '' }}">
                            {!! Form::select('thana', ['Option1' => 'Thana 1', 'Option2' => 'Thana 2'], null, [
                                'class' => 'form-control input-md required',
                                'id' => 'thana',
                            ]) !!}
                            {!! $errors->first('thana', '<span class="help-block">:message</span>') !!}
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
                                'class' => 'required',
                                'id' => 'no',
                            ]) !!} Inactive</label>

                            {!! $errors->first('is_active', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-left">
                                <a href="{{ url('/training/speaker/list') }}">
                                    {!! Form::button('<i class="fa fa-times"></i> Close', ['type' => 'button', 'class' => 'btn btn-default']) !!}
                                </a>
                            </div>
                            <div class="float-right">
                                <button id="submit" type="submit" class="btn btn-primary pull-right"><i
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
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css') }}">
    <script src="{{ asset('assets/scripts/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
@endsection
