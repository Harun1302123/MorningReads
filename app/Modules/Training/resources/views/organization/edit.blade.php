<?php
if (!ACL::getAccsessRight('Training', '-E-')) {
    die('You have no access right! Please contact system administration for more information');
}
?>

@extends('layouts.admin')

@section('header-resources')
    <style>
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
                    <h5><strong> Edit Organization </strong></h5>
                </div>

                {!! Form::open([
                    'url' => '/training/organization/update-data',
                    'method' => 'post',
                    'class' => 'form-horizontal smart-form',
                    'id' => 'currency-form',
                ]) !!}
                <div class="card-body">
                    <input type="hidden" name="app_id" value="{{ $id }}" />
                    <div class="form-group col-md-12 row">
                        {!! Form::label('organization_name', 'Organization Name', ['class' => 'col-md-2 required-star']) !!}
                        <div class="col-md-4 {{ $errors->has('organization_name') ? 'has-error' : '' }}">
                            {!! Form::text('organization_name', $organization_data->organization_name, [
                                'class' => 'form-control input-md required',
                            ]) !!}
                            {!! $errors->first('organization_name', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="form-group col-md-12 row">
                            {!! Form::label('is_active', 'Active Status: ', ['class' => 'col-md-2 required-star']) !!}
                            <div class="col-md-4 {{ $errors->has('is_active') ? 'has-error' : '' }}">
                                <label>{!! Form::radio('is_active', '1', $organization_data->is_active == 1 ? 'checked' : '', [
                                    'class' => 'required',
                                    'id' => 'yes',
                                ]) !!} Active</label>
                                <label>{!! Form::radio('is_active', '0', $organization_data->is_active == 0 ? 'checked' : '', [
                                    'class' => ' required',
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
                                <a href="{{ url('/training/organization/all-list') }}">
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
@endsection
