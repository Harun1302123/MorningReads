@extends('layouts.admin')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit About Us </h3>
        </div>
        {!! Form::open([
            'route' => 'about-us.store',
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
                    <h3 class="card-title pt-2 pb-2"> About Us Information </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div
                            class="form-group col-md-12 {{ $errors->has('details') ? 'has-error' : '' }}">
                            <div class="row">
                                {!! Form::label('details', 'Details:', [
                                    'class' =>'col-md-2 control-label']) !!}
                                <div class="col-md-10">
                                    {!! Form::textarea('details', $data->details, ['class' => 'form-control details', 'size' => '5x3']) !!}
                                    {!! $errors->first('details', '<span class="help-block">:message</span>') !!}
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
    <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
    <script>
        $("#form_id").validate({
            errorPlacement: function() {
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
    </script>
@endsection <!--- footer script--->
