@extends('public_home.front')

@include('public_home.login_css')

@section('body')

    <div class="login-details my-5 container">

        @include('partials.messages')

        <div id="form">
            <div id="title">
                <h2>SignUp</h2>
            </div>


            {!! Form::open(array('url' => 'training/identity-verify','method' => 'post', 'class' => 'form-horizontal', 'id' => 'identityVerifyForm', 'name' => 'identityVerifyForm', 'enctype' =>'multipart/form-data', 'files' => 'true')) !!}

            <div class="row">
                <div class="col-md-12 {{$errors->has('user_name') ? 'has-error' : ''}}">
                    <label class="required-star" for="user_name">Name</label>
                    <input type="text" class="input-md" name="user_name" id="user_name" placeholder="Enter Your Name">
                    {!! $errors->first('user_name', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="col-md-12 {{$errors->has('user_email') ? 'has-error' : ''}}">
                    <label class="required-star" for="user_email">Email</label>
                    <input type="text" class="input-md" name="user_email" id="user_email"  placeholder="Enter Your email">
                    {!! $errors->first('user_email', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="col-md-12 {{$errors->has('user_mobile_no') ? 'has-error': ''}}">
                    <label class="required-star" for="">Phone Number</label>
                    {!! Form::text('user_mobile_no', '', $attributes = ['class' => ' required bd_mobile', 'placeholder' => 'Enter your Number', 'id' => 'user_mobile_no']) !!}
                </div>

                <div class="col-md-12 {{$errors->has('user_gender') ? 'has-error' : ''}}">
                    <div class="mb-1">
                        <label class="required-star mb-0" for="user_gender">Gender</label><br>

                        <div class="form-check form-check-inline login-checkbox">
                            <input class="form-check-input" type="radio" name="user_gender" id="male" value="Male">
                            <label class="form-check-label" for="male">Male</label>
                        </div>

                        <div class="form-check form-check-inline login-checkbox">
                            <input class="form-check-input" type="radio" name="user_gender" id="female" value="Female">
                            <label class="form-check-label" for="female">Female</label>
                        </div>

                        <div class="form-check form-check-inline login-checkbox">
                            <input class="form-check-input" type="radio" name="user_gender" id="other" value="Other">
                            <label class="form-check-label" for="other">Other</label>
                        </div>

                        {!! $errors->first('user_gender', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>


                <div class="col-md-12 {{$errors->has('identity_type') ? 'has-error' : ''}}">
                    <fieldset>
                        <legend>Identification Type</legend>
                        <div class="radio-buttons">
                            <input type="radio" id="nid" name="identity_type" value="nid">
                            <label for="nid">NID</label>
                            <input type="radio" id="tin" name="identity_type" value="tin">
                            <label for="tin">TIN</label>
                            <input type="radio" id="brc" name="identity_type" value="brc">
                            <label for="brc">BRC</label>
                            <input type="radio" id="passport" name="identity_type" value="passport">
                            <label for="passport">Passport</label>
                        </div>
                    </fieldset>
                    <div id="nid_section" class="attachment-section">
                        <label for="nid_number">NID Number</label>
                        <input type="text" id="nid_number" name="nid_number" placeholder="Enter your NID number">
                        <label for="nid_attachment">Upload NID Copy</label>
                        <input type="file" name="nid_attachment" id="nid_attachment" accept="application/pdf">
                        <small class="" style="font-size: 9px; font-weight: bold; color: #666363; font-style: italic">
                            [Format: *.PDF | Maximum 3 MB, Application with Name & Signature]
                        </small>
                    </div>

                    <div id="tin_section" class="attachment-section">
                        <label for="tin_number">TIN Number</label>
                        <input type="text" id="tin_number" name="tin_number" placeholder="Enter your TIN number">
                        <label for="tin_attachment">Upload TIN Copy</label>
                        <input type="file" name="tin_attachment" id="tin_attachment" accept="application/pdf">
                        <small class="" style="font-size: 9px; font-weight: bold; color: #666363; font-style: italic">
                            [Format: *.PDF | Maximum 3 MB, Application with Name & Signature]
                        </small>
                    </div>

                    <div id="brc_section" class="attachment-section">
                        <label for="brc_number">BRC Number</label>
                        <input type="text" id="brc_number" name="brc_number" placeholder="Enter your BRC number">
                        <label for="brc_attachment">Upload BRC Copy</label>
                        <input type="file" name="brc_attachment" id="brc_attachment" accept="application/pdf">
                        <small class="" style="font-size: 9px; font-weight: bold; color: #666363; font-style: italic">
                            [Format: *.PDF | Maximum 3 MB, Application with Name & Signature]
                        </small>
                    </div>

                    <div id="passport_section" class="attachment-section">
                        <label for="passport_number">Passport Number</label>
                        <input type="text" id="passport_number" name="passport_number" placeholder="Enter your passport number">
                        <label for="passport_attachment">Upload Passport Copy</label>
                        <input type="file" name="passport_attachment" id="passport_attachment" accept="application/pdf">
                        <small class="" style="font-size: 9px; font-weight: bold; color: #666363; font-style: italic">
                            [Format: *.PDF | Maximum 3 MB, Application with Name & Signature]
                        </small>
                    </div>
                </div>
            </div>
            <div id="SignUp">
                <button>Sign Up</button>
                <p>------------ Or ------------</p>
                <p>Already have an account? <a href="{{ route('login') }}" target="_blank">Login</a></p>
                <p><a href="/">Back to Home</a></p>
            </div>


            {{-- reCAPTCHA --}}
            {{-- <div class="form-group mt-2 {{$errors->has('g-recaptcha-response') ? 'has-error' : ''}}">
                <div class="offset-md-2 col-md-6">

                    {!! NoCaptcha::renderJs() !!}
                    {!! NoCaptcha::display() !!}
                    {!! $errors->first('g-recaptcha-response','<span class="help-block">:message</span>') !!}
                </div>
            </div> --}}

            {{--  <div class="form-group text-center">
                  <button type="submit" title="You must fill in all of the fields"
                          class="btn btn-md btn-success round-btn">
                      <i class="fa fa-check"></i>
                      <strong>Submit</strong>
                  </button>
              </div>--}}

            {!! Form::close() !!}


        </div>
    </div>
@endsection

@include('public_home.login_js')
