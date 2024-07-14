<!DOCTYPE html>
<!--[if IE 8]>
<html lang="bn" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="bn" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="bn" class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>One Stop Service platform for Ease of doing business in Bangladesh</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <meta name="author" content="{{ config('app.project_name') }}"/> --}}
    <meta name="keywords" content="OSS framework">
    <meta name="description"
        content="One Stop Service is an online platform integrating relevant Government agencies for providing efficient and transparent
            services to domestic and foreign investors" />

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <!-- Fav icon -->
    {{-- <link rel="shortcut icon" type="image/png" href="{{ asset("assets/images/favicon.ico") }}"/> --}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/stylesheets/custom.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}" />
    <style>
        .help-block{
            color: red;
            font-size: 12px;
        }
    </style>
    @yield('header-resources')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        {{ csrf_field() }}

        @include ('navigation.nav')

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @yield('body')
                </div>
            </section>
        </div>
        @include ('layouts.footer')
    </div>

    <script>
        var ip_address = '<?php echo $_SERVER['REMOTE_ADDR']; ?>';
        var user_id = '{{ Auth::user()->id }}';
        var message = 'Ok';
        @if (isset($exception))
            message = "Invalid Id! 401";
        @endif
        var project_name = "{{ config('app.APP_NAME') }}" + "." + "<?php echo config('app.APP_ENV'); ?>";
    </script>
    @if ((Request::is('vue/*') or Request::is('settings/*')) &&
        Request::segment(2) !== 'document-v2' &&
        Request::segment(2) !== 'application-guideline')
        @auth
            <script>
                window.user = @json(auth()->user());
            </script>
        @endauth

        <script src="{{ mix('js/app.js') }}"></script>
    @endif


    <!-- jQuery -->
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>


    <!-- Bootstrap 4 -->
    <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>

    @if (!Request::is('users/delegate'))
        <script type="text/javascript" src="{{ mix('js/admin.js') }}"></script>
    @endif


    <script type="text/javascript" src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/jquery.validate.min.js') }}"></script>


    <script>
        // Add CSRF token for all types of ajax request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>


    @yield('footer-script')

    <?php
    //    if (config('app.mongo_audit_log')) {
    //        require_once public_path() . '/url_webservice/set-app-data.blade.php';
    //    }
    ?>
    @if (Auth::user())
        <script type="text/javascript">
            var setSession = '';

            function getSession() {
                $.get("/users/get-user-session", function(data, status) {
                    if (data.responseCode == 1) {
                        setSession = setTimeout(getSession, 120000);
                    } else {
                        alert('Your session has been closed. Please login again');
                        window.location.replace('/login');
                        // swal({
                        //     type: 'warning',
                        //     title: 'Oops...',
                        //     text: 'Your session has been closed. Please login again',
                        //     footer: '<a href="/login">Login</a>'
                        // }).then((result) => {
                        //     if (result.value) {
                        //         window.location.replace('/login')
                        //     }
                        // })
                    }
                });
            }

            setSession = setTimeout(getSession, 120000);
        </script>
    @endif

</body>

</html>
