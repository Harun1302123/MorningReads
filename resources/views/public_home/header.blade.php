<?php
$osspid = new \App\Libraries\Osspid([
    'client_id' => config('osspid.osspid_client_id'),
    'client_secret_key' => config('osspid.osspid_client_secret_key'),
    'callback_url' => config('app.PROJECT_ROOT') . '/osspid-callback',
]);
$redirect_url = $osspid->getRedirectURL();
?>
<style>
    .reg_btn {
        background-color: #fff;
        color: #006a4e;
        border-color: #006a4e;
    }

    .nav-background{
        background: linear-gradient(90deg, #560F54 35%, #BC21B8 100%);
    }
    .nav-item span{
font-size: 16px;
font-style: normal;
font-weight: 500;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-success nav-background">
    <div class="collapsse navbar-collapse container" id="navbarSupportedContents">
        <ul class="navbar-nav mr-auto text-white">
            <li class="nav-item d-sm-block mr-4">
                <img src="{{asset('/assets/images/call.png')}}" alt="">  
                <span class="ml-2">01780418099</span>
            </li>

            <li class="nav-item  d-sm-block">
                <img src="{{asset('/assets/images/top-mail.png')}}" alt=""> 
                <span class="ml-2">help@mpo.com</span>
            </li>

        </ul>
    </div>
</nav>
<div class="site-main">
<div id="pageTopSec">
    <header class="site-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <div class="site-nav-box">
                    <a class="navbar-brand" href="/">
                        <div class="site-logo">
                            <img src="{{asset('/assets/images/logo.png')}}" width="300" alt="Logo">
                        </div>
                    </a>

                    <button class="navbar-toggler resView collapsed" type="button" data-toggle="collapse"
                        data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav btb-navbar">
                        <li class="nav-item">
                            <a class="nav-link smoothScroll active" href="/">
                                <span class="nav-text">Home</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link smoothScroll" href="{{ route('frontend.about_us') }}">
                                <span class="nav-text">About us</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link smoothScroll" href="{{ route('frontend.user_manual') }}">
                                <span class="nav-text">User Manual</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link smoothScroll" href="{{ route('frontend.notice_details') }}">
                                <span class="nav-text">Notice</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link smoothScroll{{ Request::is('contact') ? 'active' : '' }}"
                               href="{{ route('frontend.contact') }}">
                                <span class="nav-text">Contact</span>
                            </a>
                        </li>
                        <li class="top-options">
                            <a class="nav-top-btn" href="{{ route('login') }}">Sign Up/Log in</a>
                        </li>
                      {{--  <li class="top-options">
                            <a class="nav-top-btn" href="<?php echo @$redirect_url; ?>">Sign Up/Log in</a>                        
                        </li>--}}
                    </ul>
                </div>

            </div>
        </nav>
    </header>
</div>
</div>