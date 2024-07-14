<div id="tab_1" class=" tab-pane active">
    {!! Form::open(array('url' => '/users/profile_updates/'.$id,'method' =>'post','id'=>'update_form', 'class' => 'form-horizontal',
                                                'enctype'=>'multipart/form-data')) !!}
    <div class="row">

        <div class="col-md-6">
            <fieldset>
                {!! Form::hidden('Uid', $id) !!}
                <div class="form-group row">
                    <label
                        class="col-lg-4 text-left">{!! trans('Users::messages.user_type') !!}</label>
                    <div class="col-lg-8">
                        {{ $user_type_info->type_name }}
                    </div>
                </div>
                @if($users->desk_id = '0')
                    <div class="form-group row">
                        <label
                            class="col-lg-4 text-left">{!! trans('Users::messages.user_desk_name') !!}</label>
                        <div class="col-lg-7">
                            {{$user_desk->desk_name}}
                        </div>
                    </div>
                @endif

                <div class="form-group row">
                    <label
                        class="col-lg-4 text-left">{!! trans('Users::messages.user_email') !!}</label>
                    <div class="col-lg-8">
                        {{ $users->user_email }}
                    </div>
                </div>

                <div
                    class="form-group row {{ $errors->has('user_first_name') ? 'has-error' : ''}}">
                    <label
                        class="col-lg-4 text-left ">{!! trans('Users::messages.user_name') !!}</label>
                    <div class="col-lg-8">
                        <div class="input-group ">
                            {!! Form::text('user_first_name',$users->user_first_name, $attributes = array('class'=>'form-control required',
                            'placeholder'=>'Enter Name','id'=>"user_first_name", 'data-rule-maxlength'=>'50', 'readonly' => true)) !!}
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i
                                        class="fa fa-user"></i></span>
                            </div>
                        </div>
                        {!! $errors->first('user_first_name','<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div
                    class="form-group row {{ $errors->has('user_gender') ? 'has-error' : '' }}">
                    <label
                        class="col-lg-4 text-left required-star">{!! trans('Users::messages.user_gender') !!}</label>
                    <div class="col-md-7">
                        @if($users->user_gender ==  'Male')
                            <label
                                class="identity_hover">{!! Form::radio('user_gender', 'Male',  ($users->user_gender ==  'Male') ?  true : false, ['class'=>'user_gender']) !!}
                                Male
                            </label>
                        @elseif($users->user_gender ==  'Female')
                            <label
                                class="identity_hover">{!! Form::radio('user_gender', 'Female',  ($users->user_gender ==  'Female') ?  true : false, ['class'=>'user_gender']) !!}
                                Female
                            </label>
                        @elseif($users->user_gender ==  'Not defined')
                            <label
                                class="identity_hover">{!! Form::radio('user_gender', 'Not defined',  ($users->user_gender ==  'Not defined') ?  true : false, ['class'=>'user_gender']) !!}
                                Others
                            </label>
                        @endif
                    </div>
                </div>

                @if(Auth::user()->user_type == '4x404')
                    <div
                        class="form-group row {{ $errors->has('designation') ? 'has-error' : '' }}">
                        <label
                            class="col-lg-4 text-left required-star">{!! trans('Users::messages.user_designation') !!}</label>
                        <div class="col-lg-8">
                            {!! Form::text('designation',$users->designation, ['class'=>'form-control required','data-rule-maxlength'=>'40',
                            'placeholder'=>'Enter your Designation']) !!}
                            {!! $errors->first('designation','<span class="help-block">:message</span>')
                            !!}
                        </div>
                    </div>
                @endif

                <div class="form-group row">
                    <label
                        class="col-lg-4 text-left">{!! trans('Users::messages.user_dob') !!}</label>
                    <div class="col-lg-8">
                        <div class="input-group ">
                            <?php
                            $dob = '';
                            if ($users->user_DOB) {
                                $dob = App\Libraries\CommonFunction::changeDateFormat($users->user_DOB);
                            }
                            ?>
                            {!! Form::text('user_DOB', $dob, ['class'=>'form-control datepicker', 'readonly' => true]) !!}
                            <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2"><i
                                  class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        {!! $errors->first('user_DOB','<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div
                    class="form-group row {{ $errors->has('user_mobile') ? 'has-error' : ''}}">
                    <label
                        class="col-lg-4 text-left required-star">{!! trans('Users::messages.user_mobile') !!}</label>
                    <div class="col-lg-8">

                        {!! Form::text('user_mobile',$users->user_mobile, $attributes = array('class'=>'form-control required mobile_number_validation',
                        'placeholder'=>'Enter your Mobile Number','id'=>"user_mobile")) !!}

                        {!! $errors->first('user_mobile','<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div
                    class="form-group row {{ $errors->has('contact_address') ? 'has-error' : ''}}">
                    <label
                        class="col-lg-4 text-left">Contact address</label>
                    <div class="col-lg-8">

                        {!! Form::text('contact_address',$users->contact_address, $attributes = array('class'=>'form-control',
                        'placeholder'=>'Enter your contact address','id'=>"contact_address")) !!}

                        {!! $errors->first('contact_address','<span class="help-block">:message</span>') !!}
                    </div>
                </div>


                @if(Auth::user()->user_type != '1x101')
                    <div
                        class="form-group row {{$errors->has('identity_type') ? 'has-error': ''}}">
                        {!! Form::label('identity_type',trans('Users::messages.identity_type'),['class'=>'text-left col-md-4', 'id' => 'identity_type_label']) !!}
                        <div class="col-md-7">
                            @if($users->identity_type ==  'passport')
                                <label
                                    class="identity_hover">{!! Form::radio('identity_type', 'passport',  ($users->identity_type ==  'passport') ?  true : false, ['class'=>'identity_type', 'onclick' => 'selectIdentityType(this.value)']) !!}
                                    {!! trans('Users::messages.passport') !!}
                                </label>
                            @elseif($users->identity_type ==  'nid')
                                <label
                                    class="identity_hover">{!! Form::radio('identity_type', 'nid',  ($users->identity_type ==  'nid') ?  true : false, ['class'=>'identity_type', 'onclick' => 'selectIdentityType(this.value)']) !!}
                                    {!! trans('Users::messages.user_nid') !!}
                                </label>
                            @elseif($users->identity_type ==  'tin')
                                <label
                                    class="identity_hover">{!! Form::radio('identity_type', 'tin',  ($users->identity_type ==  'tin') ?  true : false, ['class'=>'identity_type', 'onclick' => 'selectIdentityType(this.value)']) !!}
                                    {!! trans('Users::messages.tin') !!}</label>
                            @elseif($users->identity_type ==  'brc')
                                <label
                                    class="identity_hover">{!! Form::radio('identity_type', 'brc',  ($users->identity_type ==  'brc') ?  true : false, ['class'=>'identity_type', 'onclick' => 'selectIdentityType(this.value)']) !!}
                                    BRC</label>
                            @endif
                        </div>
                    </div>

                    <div
                        class="form-group row  {{ $errors->has('passport_no') ? 'has-error' : ''}}"
                        id="passport_div">
                        <label
                            class="col-lg-4 text-left">{!! trans('Users::messages.passport_no') !!}</label>
                        <div class="col-lg-8">
                            <div class="input-group ">
                                {!! Form::text('passport_no',$users->passport_no, ['class'=>'form-control required','data-rule-maxlength'=>'40',
                               'placeholder'=>'Enter your Passport (if any)','id'=>"passport_no", 'readonly' => true]) !!}

                                <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2"><i
                                class="fa fa-book"></i></span>
                                </div>
                            </div>
                            {!! $errors->first('passport_no','<span class="help-block">:message</span>')!!}
                        </div>
                    </div>

                    <div
                        class="form-group row {{ $errors->has('user_nid') ? 'has-error' : '' }}"
                        id="nid_div">
                        <label
                            class="col-lg-4 text-left required-star">{!! trans('Users::messages.user_nid_no') !!}</label>
                        <div class="col-lg-8">
                            <div class="input-group ">
                                {!! Form::text('user_nid',$users->user_nid, ['class'=>'form-control required','data-rule-maxlength'=>'40',
                                'placeholder'=>'Enter your NID (if any)','id'=>"user_nid", 'readonly' => true]) !!}
                                <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2"><i
                                class="fa fa-book"></i></span>
                                </div>
                            </div>
                            {!! $errors->first('user_nid','<span class="help-block">:message</span>')
                            !!}
                        </div>
                    </div>

                    <div
                        class="form-group row {{ $errors->has('user_tin') ? 'has-error' : '' }}"
                        id="tin_div">
                        <label
                            class="col-lg-4 text-left required-star">{!! trans('Users::messages.tin_no') !!}</label>
                        <div class="col-lg-8">
                            <div class="input-group ">
                                {!! Form::text('user_tin',$users->user_tin, ['class'=>'form-control required','data-rule-maxlength'=>'40',
                                'placeholder'=>'Enter your TIN (if any)','id'=>"user_tin"]) !!}
                                <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2"><i
                                class="fa fa-credit-card"></i></span>
                                </div>
                            </div>
                            {!! $errors->first('user_tin','<span class="help-block">:message</span>')
                            !!}
                        </div>
                    </div>

                    <div
                        class="form-group row {{ $errors->has('user_brc') ? 'has-error' : '' }}"
                        id="brc_div">
                        <label
                            class="col-lg-4 text-left">BRC</label>
                        <div class="col-lg-8">
                            <div class="input-group ">
                                {!! Form::text('user_brc',$users->user_brc, ['class'=>'form-control','data-rule-maxlength'=>'40',
                                'placeholder'=>'Enter your BRC (if any)','id'=>"user_brc"]) !!}
                                <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2"><i
                                class="fa fa-credit-card"></i></span>
                                </div>
                            </div>
                            {!! $errors->first('user_brc','<span class="help-block">:message</span>')
                            !!}
                        </div>
                    </div>
                @endif

                @if(Auth::user()->user_type == '10x112')
                    <div class="form-group row">
                        <label class="col-lg-4 text-left">Identity Attachment</label>
                        <div class="col-lg-8">
                            <a type="button" class="btn btn-success" target="_blank" href="{{url($users->identity_attachment)}}"> Open </a> 
                        </div>
                    </div>
                @endif


                <div
                    class="form-group row {{$errors->has('identity_type') ? 'has-error': ''}}">
                    {!! Form::label('identity_type',trans('Users::messages.to_step'),['class'=>'text-left col-md-4', 'id' => 'identity_type_label']) !!}
                    <div class="col-md-7">
                        <label
                            class="sd">{!! Form::radio('auth_token_allow', 1,  ($users->auth_token_allow ==  '1') ?  true : false) !!}
                            {!! trans('Users::messages.yes') !!}&nbsp;&nbsp;
                        </label>
                        <label
                            class="sd">{!! Form::radio('auth_token_allow', 0,  ($users->auth_token_allow ==  '0') ?  true : false) !!}
                            {!! trans('Users::messages.no') !!}
                        </label>
                    </div>
                </div>


                @if($users->user_status == "rejected")
                    <div class="form-group row">
                        <label class="col-lg-4 text-left">Reject Reason</label>
                        <div class="col-lg-8">
                            {{ $users->user_status_comment }}
                        </div>
                    </div>
                @endif


            </fieldset>
        </div>

        <div class="col-md-1 col-sm-1"></div>

        <div class="col-md-5 col-sm-5 col-sm-offset-1">
            <div class="card card-default" id="browseimagepp">
                <div class="row">
                    <div class="col-sm-6 col-md-4 addImages" style="max-height:300px;">
                        <label class="center-block image-upload" for="user_pic"
                               style="margin: 0px">
                            <figure>
                                <img src="{{ url('users/profile-pic/'.Auth::user()->user_pic) }}" onerror="this.src=`{{asset('/assets/images/default_profile.jpg')}}`"
                                    class="img-responsive img-thumbnail"
                                    id="user_pic_preview"/>
                            </figure>
                            <input type="hidden" id="user_pic_base64"
                                   name="user_pic_base64" class="required"/>
                            @if(!empty($users->user_pic))
                                <input type="hidden" name="user_pic"
                                       value="{{$users->user_pic}}"/>
                            @endif
                        </label>
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h4 id="profile_image">
                            {!! Form::label('user_pic',trans('Users::messages.profile_image'), ['class'=>'text-left required-star']) !!}
                        </h4>
                        <span class="text-success col-lg-8 text-left"
                              style="font-size: 9px; font-weight: bold; display: block;">[File Format: *.jpg/ .jpeg/ .png | Width 300PX, Height 300PX]</span>

                        <span id="user_err" class="text-danger col-lg-8 text-left"
                              style="font-size: 10px;"> {!! $errors->first('applicant_photo','<span class="help-block">:message</span>') !!}</span>
                        <div class="clearfix"><br/></div>
                        <label class="btn btn-primary btn-file">
                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                            {!! trans('Users::messages.browse') !!}<input type="file"
                                                                          class="custom-file-input input-sm  {{empty($users->user_pic) ? 'required' : ''}}"
                                                                          name="user_pic"
                                                                          id="user_pic"
                                                                          onchange="imageUploadWithCroppingAndDetect(this, 'user_pic_preview', 'user_pic_base64')"
                                                                          size="300x300"/>


                        </label>

                        <label class="btn btn-primary btn-file" id="cameraclick">
                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                            Camera <span class="btn btn-primary"></span>
                        </label>
                    </div>


                </div>
            </div>
            <div class="card card-default" style="display: none" id="camera">
                <div class="row">
                    <div class="col-sm-6 col-md-8">


                    </div>

                    <div class="col-md-6">

                        <h4>
                            {!! Form::label('user_pic',trans('Users::messages.profile_image'), ['class'=>'text-left required-star']) !!}
                        </h4>
                        <span class="text-success col-lg-12 text-left"
                              style="font-size: 9px; font-weight: bold; display: block;">[File Format: *.jpg/ .jpeg/ .png | Width 300PX, Height 300PX]</span>

                        <div id="my_camera"></div>
                        <div id="results">Your captured image will appear here...</div>

                        <br/>

                        <input type=button id="ts" value="Take Snapshot"
                               onClick="take_snapshot()">

                        <input type="hidden" name="image" class="image-tag">

                        <button type="button" id="reset_image_from_webcamera"
                                class="btn btn-warning btn-xs" value="">Reset image
                        </button>

                    </div>

                </div>
            </div>

            @if(Auth::user()->user_type == '4x404')
                <br>
                <div class="card card-default">
                    <div class="row">
                        <div class="col-sm-6 col-md-4 addImages" style="max-height:300px;">
                            <label class="center-block image-upload" for="signature">
                                <figure>
                                    <img src="{{ url('users/signature/'.Auth::user()->signature) }}"
                                         onerror="this.src=`{{asset('/assets/images/paper-business-contract-pen-signature-icon-vector-15749289.jpg')}}`"
                                        class="img-responsive img-thumbnail"
                                        id="signature_preview"/>
                                </figure>
                                <input type="hidden" id="signature_base64"
                                       name="signature_base64"/>
                                @if(!empty($users->signature))
                                    <input type="hidden" name="signature"
                                           value="{{$users->signature}}"/>
                                @endif
                            </label>
                        </div>
                        <div class="col-sm-6 col-md-8">
                            <h4 id="profile_image">
                                {!! Form::label('signature','Signature:', ['class'=>'text-left required-star']) !!}
                            </h4>
                            <span class="text-success col-lg-8 text-left"
                                  style="font-size: 9px; font-weight: bold; display: block;">[File Format: *.jpg/ .jpeg/ .png | Width 300PX, Height 80PX]</span>
                            <div class="clearfix"><br/></div>
                            <span id="user_err" class="text-danger col-lg-8 text-left"
                                  style="font-size: 10px;"> {!! $errors->first('signature','<span class="help-block">:message</span>') !!}</span>
                            <label class="btn btn-primary btn-file">
                                <i class="fa fa-picture-o" aria-hidden="true"></i>
                                {!! trans('Users::messages.browse') !!}<input type="file"
                                                                              class="custom-file-input input-sm {{!empty($users->signature) ? '' : 'required'}}"
                                                                              name="signature"
                                                                              id="signature"
                                                                              onchange="imageUploadWithCropping(this, 'signature_preview', 'signature_base64')"
                                                                              size="300x80"/>
                            </label>
                        </div>
                    </div>

                </div>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Asigned Desk</legend>
                    <div class="control-group">
                        <?php $i = 1;?>
                        @foreach($desk as $desk_name)
                            <dd>{{$i++}}. {!!$desk_name->desk_name!!}</dd>
                        @endforeach
                    </div>
                </fieldset>

                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Office</legend>
                    <div class="control-group">
                        <?php $i = 1;?>
                        @foreach($park as $park_name)
                            <dd>{{$i++}}. {!!$park_name->park_name!!}</dd>
                        @endforeach
                    </div>
                </fieldset>

                @if(checkUserTrainingDesk())
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Assigned Training Desk</legend>
                    <div class="control-group">
                        <dd>{{ userTrainingDesk() }}</dd>
                    </div>
                </fieldset>
            @endif
            @endif
        </div>

        <div class="col-md-12"><br>
            <div class="float-right">
                <button type="submit" class="btn btn-info btn-lg "
                        id='update_info_btn'><b><i
                            class="fa fa-save"></i> {!! trans('Users::messages.save') !!}
                    </b>
                </button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

</div>