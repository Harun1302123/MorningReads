
<div id="tab_3" class="container tab-pane fade"><br>

    {!! Form::open(array('url' => '/users/process-delegation','method' =>
              'patch','id'=>'delegation', 'class' => '','enctype'
              =>'multipart/form-data')) !!}
    <div class="form-group row col-lg-8">
        <div class="col-lg-3"><label class="required-star">User Type</label></div>
        <div class="col-lg-6">
            <?php $userDesignation = ($delegate_to_types ? $delegate_to_types : '') ?>
            {!! Form::select('designation', $userDesignation, '', $attributes =
            array('class'=>'form-control required', 'onchange'=>'getUserDeligate()',
            'placeholder' => 'Select Type', 'id'=>"designation_2")) !!}
        </div>
    </div>

    <div class="form-group row  col-lg-8">
        <div class="col-lg-3"><label class="required-star">Delegated User</label>
        </div>
        <div class="col-lg-6">
            {!! Form::select('delegated_user', [] , '', $attributes =
            array('class'=>'form-control required',
            'placeholder' => 'Select User', 'id'=>"delegated_user")) !!}
        </div>
    </div>

    <div class="form-group row  col-lg-8">
        <div class="col-lg-3"><label>Remarks</label></div>
        <div class="col-lg-6">
            {!! Form::text('remarks','', $attributes = array('class'=>'form-control',
            'placeholder'=>'Enter your Remarks','id'=>"remarks")) !!}
        </div>
    </div>


    <div class="form-group  col-lg-4">
        <div class="float-right m-auto">
            <button type="submit" class="btn btn-primary " id='update_info_btn'>
                <b>Deligate</b>
            </button>
        </div>
    </div>
    {!! Form::close() !!}
</div>