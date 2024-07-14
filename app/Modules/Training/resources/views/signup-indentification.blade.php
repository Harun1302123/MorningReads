<style>
    .margin-0 {
        margin-left: 0px !important;
        margin-right: 0px !important;
    }
</style>
<div class="p-3">
    <div class="row">
        <div class="col-md-12 {{$errors->has('signup_type') ? 'has-error': ''}}">
            <div class="form-group row">
                <div class="col-md-4">
                    <label class="required-star" for="signup_type" style="font-weight: normal">Signup Type</label>
                </div>
                <div class="col-sm-8">
                    {!! Form::select('signup_type', ['bida' => 'Investor Applicant', 'trainee' => 'Trainee Applicant'], '', 
                    $attributes = array('class'=>'form-control input-md required','id'=>"signup_type")) !!}
                    <span class="text-danger" id="signup_type"></span>
                </div>
            </div>
            
        </div>
    </div>
</div>
        

<div class="hidden trainee_action_div">
    {!! Form::open(array('url' => 'training/identity-verify','method' => 'post', 'class' => 'form-horizontal', 'id' => 'identityVerifyForm', 'name' => 'identityVerifyForm', 'enctype' =>'multipart/form-data', 'files' => 'true')) !!}
    <div class="px-3">
        <div class="row">
            <div class="col-md-12 row my-2 pr-0 {{$errors->has('user_name') ? 'has-error': ''}}">
                <div class="col-md-4">
                    <label class="required-star" for="">Name</label>
                </div>
                <div class="col-md-8 pr-0">
                    <input type="text" class="form-control input-md" name="user_name" value="{{Session::get('oauth_data')->user_full_name}}" id="user_name" readonly>
                </div>
            </div>
            <div class="col-md-12 row my-2 pr-0 {{$errors->has('user_email') ? 'has-error': ''}}">
                <div class="col-md-4">
                    <label class="required-star" for="">Email</label>
                </div>
                <div class="col-md-8 pr-0">
                    <input type="text" class="form-control input-md" value="{{Session::get('oauth_data')->user_email}}" name="user_email" id="user_email" readonly>
                </div>
            </div>
            <div class="col-md-12 row my-2 pr-0 {{$errors->has('user_mobile_no') ? 'has-error': ''}}">
                <div class="col-md-4">
                    <label class="required-star" for="">Phone Number</label>
                </div>
                <div class="col-md-8 pr-0">
                    <input type="text" class="form-control input-md" value="{{Session::get('oauth_data')->mobile}}" name="user_mobile_no" id="user_mobile_no" readonly>
                </div>
            </div>
            <div class="col-md-12 row my-2 pr-0 {{$errors->has('user_gender') ? 'has-error': ''}}">
                <div class="col-md-4">
                    <label class="required-star" for="">Gender</label>
                </div>
                <div class="col-md-8 pr-0">
                    <input type="text" class="form-control input-md" value="{{Session::get('oauth_data')->gender}}" name="user_gender" id="user_gender" readonly>
                </div>
            </div>
        </div>
    </div>

    
    {{-- reCAPTCHA --}}
    <div class="form-group mt-2 {{$errors->has('g-recaptcha-response') ? 'has-error' : ''}}">
        <div class="offset-md-2 col-md-6">
            {{-- {!! Recaptcha::render() !!} --}}
            {!! NoCaptcha::renderJs() !!}
            {!! NoCaptcha::display() !!}
            {!! $errors->first('g-recaptcha-response','<span class="help-block">:message</span>') !!}
        </div>
    </div>
    
    <div class="form-group text-center">
        <button type="submit" title="You must fill in all of the fields"
                class="btn btn-md btn-success round-btn">
            <i class="fa fa-check"></i>
            <strong>Submit</strong>
        </button>
    </div>

    {!! Form::close() !!}
</div>

