<?php

use Illuminate\Support\Facades\Cache;

$user_type = Auth::user()->user_type;
$type = explode('x', $user_type);
$Segment = Request::segment(3);
$is_eligibility = 0;
if ($user_type == '5x505') {
    $is_eligibility = \App\Libraries\CommonFunction::checkEligibility();
}
$prefix = '';
if ($type[0] == 5) {
    $prefix = 'client';
}
?>


<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    {{-- <a href="index3.html" class="brand-link"> --}}
    {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" --}}
    {{-- style="opacity: .8"> --}}
    {{-- <span class="brand-text font-weight-light">AdminLTE 3</span> --}}
    {{-- </a> --}}

    <div class="row">
        <div class="col">
            <div class="mx-auto w-50 pt-3">
                <a href="{{ url('/dashboard') }}" class="brand-linkd ">
                    {{-- <span class="logo-lg ">{!! Html::image(Cache::get('logo-info')->logo, 'logo', ['width' => 100, 'height' => 50]) !!}</span> --}}

                    <span class="logo-lg ">
                        <img width="100" height="50" src="{{ url(Cache::get('logo-info')->logo) }}"
                             onerror="this.src=`{{asset('/assets/images/photo_default.png')}}`"
                            alt="{{ config('app.project_name') }} - Logo" class="img-responsive">
                    </span>
                </a>
            </div>
        </div>
    </div>
    <hr>

    <!-- Sidebar -->
    <div class="sidebar" style="padding-bottom: 50px;">
        <!-- Sidebar user panel (optional) -->
{{--        <div class="user-panel mt-3 pb-3 mb-3 d-flex">--}}
{{--            <div class="image">--}}
{{--                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">--}}
{{--            </div>--}}
{{--            <div class="info">--}}
{{--                <a href="#" class="d-block">Alexander Pierce</a>--}}
{{--            </div>--}}
{{--        </div>--}}

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline"> --}}
        {{-- <div class="input-group" data-widget="sidebar-search"> --}}
        {{-- <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search"> --}}
        {{-- <div class="input-group-append"> --}}
        {{-- <button class="btn btn-sidebar"> --}}
        {{-- <i class="fas fa-search fa-fw"></i> --}}
        {{-- </button> --}}
        {{-- </div> --}}
        {{-- </div> --}}
        {{-- </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-legacy" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item ">
                    <a href="{{ url('/dashboard') }}"
                        class="nav-link {{ Request::is('dashboard') || Request::is('dashboard/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @if ($is_eligibility || in_array($type[0], [6]))
                    <li class="nav-item  ">
                        <a href="{{ url('client/company-profile/create') }}"
                            class="nav-link {{ Request::is('client/company-profile/create') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                {!!trans('CompanyProfile::messages.company_profile')!!}
                            </p>
                        </a>
                    </li>
                @endif

                @if ($is_eligibility || in_array($type[0], [1, 4, 6]))
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('client/process/list') || Request::is('client/process/details/*') || Request::is('client/process/industry-new/*') || Request::is('process/industry-new/*') || Request::is('industry-new/list/*') || Request::is('client/industry-new/list/*') || Request::is('process/list') || Request::is('process/list/*') ? 'active' : '' }}"
                            href="{{ url("$prefix/process/list") }}">
                            <i class="nav-icon fa fa-file  fa-fw"></i>
                            <p>{!! trans('messages.application') !!}</p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="{{ url("vue/process#/list/" . Encryption::encodeId(1)) }}">
                            <i class="nav-icon fa fa-file  fa-fw"></i>
                            <p>New Registration (Vue)</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url("vue/process#/list") }}">
                            <i class="nav-icon fa fa-file  fa-fw"></i>
                            <p>Process List Vue</p>
                        </a>
                    </li>
                @endif

                @include('Training::sidebar_menu')

                @if (in_array($type[0], [1, 2, 4, 6, 8]))
                    <li class="nav-item  ">
                        <a href="{{ url('/users/lists') }}"
                            class="nav-link  {{ Request::is('users/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Users</p>
                        </a>
                    </li>
                @endif

                @if (in_array($type[0], [1, 2, 4, 6,15]))
                    <li class="nav-item  ">
                        <a href="{{ url('/reportv2') }}"
                            class="nav-link {{ Request::is('reportv2') || Request::is('reportv2/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                {!! trans('messages.report') !!}
                            </p>
                        </a>
                    </li>
                @endif

                @if($type[0] == 1)

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon far fa-plus-square"></i>
                            <p>
                                {!! trans('messages.online-payment') !!}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview" style="display: none;">

                            <li class="nav-item">
                                <a href="{{ url('/spg/list') }}"
                                    class="nav-link {{ Request::is('spg/list') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{!! trans('messages.list') !!}</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/spg/payment-configuration') }}"
                                    class="nav-link {{ Request::is('spg/payment-configuration') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{!! trans('messages.configuration') !!}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('ipn/ipn-list') }}"
                                    class="nav-link {{ Request::is('ipn/*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{!! trans('messages.ipn') !!}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ Request::is('settings/*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="javascript:void(0)"
                            class="nav-link  {{ Request::is('settings/*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-wrench"></i>
                            <p>{!!trans('messages.settings')!!}</p>
                            <i class="fas fa-angle-left right"></i>
                        </a>
                        <ul class="nav-item nav-treeview">
                            <li class="nav-item ">
                                <a href="javascript:void(0)"
                                   class="nav-link  {{ Request::is('dynamic-api-engine/*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-wrench"></i>
                                    <p>Dynamic API Builder</p>
                                    <i class="fas fa-angle-left right"></i>
                                </a>
                                <ul class="nav-item nav-treeview" style="display: none;">
                                    <li class="nav-item @if (Request::is('dynamic-api-engine/*')) active @endif">
                                        <a class="nav-link" href="{{ url('/dynamic-api-engine/list') }}">
                                            <i class="fa fa-circle nav-icon" aria-hidden="true"></i>
                                            Configure API
                                        </a>
                                    </li>
                                    <li class="nav-item @if (Request::is('dynamic-api-engine/authentications/*')) active @endif">
                                        <a class="nav-link" href="{{ url('/dynamic-api-engine/authentications/list') }}">
                                            <i class="fa fa-circle nav-icon"></i> Authentications
                                        </a>
                                    </li>


                                </ul>
                            </li>

                            <li class="nav-item @if(Request::is('/settings/application-guideline/*')) active @endif">
                                <a class="nav-link" href="{{ url ('/settings/application-guideline') }}">
                                    <i class="fa fa-file fa-fw nav-icon" aria-hidden="true"></i>
                                    <span> {!! trans('messages.application_guideline') !!}</span>
                                </a>
                            </li>

                            <li class="nav-item @if(Request::is('/settings/document-v2*')) active @endif">
                                <a class="nav-link" href="{{ url ('/settings/document-v2') }}">
                                    <i class="fa fa-file fa-fw nav-icon" aria-hidden="true"></i>
                                    <span>{!! trans('messages.document') !!}</span>
                                </a>
                            </li>
                            <li class="nav-item @if(Request::is('/settings/index#/area-list') || Request::is('settings/index#/create-area') || Request::is('settings/index#/edit-area/*')) active @endif">
                                <a class="nav-link" href="{{ url ('/settings/index#/area-list') }}">
                                    <i class="fa fa-map-marker fa-fw nav-icon"></i> {!!trans('messages.area')!!}
                                </a>
                            </li>
                            <li class="nav-item @if(Request::is('/settings/index#/bank-list') || Request::is('settings/index#/bank/create') || Request::is('settings/index/bank#/edit/*')) active @endif">
                                <a class="nav-link" href="{{ url ('/settings/index#/bank-list') }}">
                                    <i class="fa fa-home fa-fw nav-icon"></i> {!! trans('messages.bank') !!}
                                </a>
                            </li>
                            <li class="nav-item @if(Request::is('/settings/index#/branch-list') || Request::is('settings/index#/branch/create') || Request::is('settings/index#/branch/edit/*')) active @endif">
                                <a class="nav-link" href="{{ url ('/settings/index#/branch-list') }}">
                                    <i class="fa fa-home fa-fw nav-icon"></i> {!! trans('messages.bank_branch') !!}
                                </a>
                            </li>
                            {{-- <li class="nav-item @if(Request::is('/settings/index#/notice') || Request::is('/settings/index#/create-notice') || Request::is('/settings/index#/edit-notice/*')) active @endif">
                                <a class="nav-link" href="{{ url ('/settings/index#/notice-list') }}">
                                    <i class="fa fa-list-alt fa-fw nav-icon"></i> {!! trans('messages.notice') !!}
                                </a>
                            </li> --}}
                            <li class="nav-item @if(Request::is('/settings/index#/security') || Request::is('/settings/index#/edit-security/*')) active @endif">
                                <a class="nav-link" href="{{ url ('/settings/index#/security') }}">
                                    <i class="fa fa-key fa-fw nav-icon"></i> {!! trans('messages.security_profile') !!}
                                </a>
                            </li>
                            <li class="nav-item @if(Request::is('/settings/index#/company-info') || Request::is('/settings/index#/company-info') || Request::is('/settings/index#/create-company') || Request::is('/settings/index#/rejected-company') || Request::is('/settings/index#/company-info-action/*')) active @endif">
                                <a class="nav-link" href="{{ url ('/settings/index#/company-info') }}">
                                    <i class="fa fa-industry nav-icon" aria-hidden="true"></i>  {!! trans('messages.company_info') !!}
                                </a>
                            </li>
                            <li class="nav-item @if(Request::is('/settings/index#/currency-list') || Request::is('/settings/index#/create-currency') || Request::is('/settings/index#/edit-currency/*')) active @endif">
                                <a class="nav-link" href="{{ url ('/settings/index#/currency-list') }}">
                                        <i class="fa fa-money-bill nav-icon" aria-hidden="true"></i>  {!! trans('messages.currency') !!}
                                </a>
                            </li>
                            <li class="nav-item @if(Request::is('/settings/index#/user-type') || Request::is('/settings/index#/edit-user-type/*')) active @endif">
                                <a class="nav-link" href="{{ url ('/settings/index#/user-type') }}">
                                    <i class="fa fa-user nav-icon" aria-hidden="true"></i>  {!! trans('messages.user_types') !!}
                                </a>
                            </li>
                            <li class="nav-item @if(Request::is('/settings/index#/pdf-print-requests') || Request::is('/settings/index#/get-pdf-print-requests') || Request::is('/settings/index#/edit-pdf-print-requests/*') || Request::is('/settings/index#/pdf-print-request-verify/*')) active @endif">
                                <a class="nav-link" href="{{ url ('/settings/index#/pdf-print-requests') }}">
                                    <i class="fa fa-file-pdf  nav-icon" aria-hidden="true"></i>  {!! trans('messages.pdf-print-requests') !!}
                                </a>
                            </li>
                            <li class="nav-item @if(Request::is('/settings/index#/email-sms-queue') || Request::is('/settings/index#/email-sms-queue/*')) active @endif">
                                <a class="nav-link" href="{{ url ('/settings/index#/email-sms-queue') }}">
                                    <i class="fa fa-sync  nav-icon" aria-hidden="true"></i>  {!! trans('messages.email_sms_queue') !!}
                                </a>
                            </li>
                           {{-- <li class="nav-item @if(Request::is('/settings/index#/terms-condition') OR Request::is('/settings/index#/create-terms-condition') OR Request::is('/settings/index#/edit-terms-condition/*')) active @endif">
                                <a class="nav-link" href="{{ url ('/settings/index#/terms-condition') }}">
                                    <i class="fa fa-book  nav-icon" aria-hidden="true"></i>  {!! trans('messages.terms_and_condition') !!}
                                </a>
                            </li>--}}
                            {{--<li class="nav-item @if(Request::is('/settings/index#/service-details/*')) active @endif">
                                <a class="nav-link" href="{{ url ('/settings/index#/service-details') }}">
                                    <i class="fa fa-cogs nav-icon" aria-hidden="true"></i>  {!! trans('messages.services_and_forms') !!}
                                </a>
                            </li>--}}

                            <li class="@if(Request::is('/settings/index#/edit-logo')) active @endif">
                                <a class="nav-link" href="{{ url ('/settings/index#/edit-logo') }}">
                                    <i class="fa fa-list-alt nav-icon" aria-hidden="true"></i>  {!! trans('messages.title_logo') !!}
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="javascript:void(0)"
                                   class="nav-link  {{ (Request::is('/settings/index#/home-page/*') ? 'active' : '') }}">
                                    <i class="nav-icon fa fa-wrench"></i>
                                    <p>{!!trans('messages.sidebar.home_page')!!}</p>
                                    <i class="fas fa-angle-left right"></i>
                                </a>
                                <ul class="nav-item nav-treeview" style="display: none;">
                                    <li class="nav-item @if(Request::is('/settings/index#/home-page/home-page-slider') OR Request::is('/settings/index#/home-page/create-home-page-slider') OR Request::is('/settings/home-page/edit-home-page-slider/*')) active @endif">
                                        <a class="nav-link" href="{{ url ('/settings/index#/home-page/home-page-slider') }}">
                                            <i class="fa fa-circle nav-icon" aria-hidden="true"></i>
                                            {!! trans('messages.home_page_slider') !!}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if(Request::is('settings/home-page/message') OR Request::is('settings/home-page/message/create') OR Request::is('settings/index#/home-page/message/edit/*')) active @endif" href="{{ url ('/settings/home-page/message') }}">
                                            <i class="nav-icon fas fa-envelope"></i>Message
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link  @if(Request::is('settings/home-page/contact-setting') OR Request::is('settings/home-page/category/edit/*')) active @endif" href="{{ url ('/settings/home-page/contact-setting') }}">
                                            <i class="nav-icon far fa-address-card"></i>Contact Us
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link  @if(Request::is('settings/home-page/about-us') OR Request::is('settings/home-page/about-us/edit/*')) active @endif" href="{{ url ('/settings/home-page/about-us') }}">
                                            <i class="nav-icon fas fa-file-alt"></i>About Us
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if(Request::is('settings/home-page/notice') OR Request::is('settings/home-page/notice/create') OR Request::is('settings/index#/home-page/notice/edit/*')) active @endif" href="{{ url ('/settings/home-page/notice') }}">
                                            <i class="fa fa-list-alt fa-fw nav-icon" aria-hidden="true"></i> {!! trans('messages.notice') !!}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if(Request::is('settings/home-page/user-manual') OR Request::is('settings/home-page/user-manual/create') OR Request::is('settings/index#/home-page/user-manual/edit/*')) active @endif" href="{{ url ('/settings/home-page/user-manual') }}">
                                            <i class="fa fa-circle nav-icon" aria-hidden="true"></i>User Manual
                                        </a>
                                    </li>
{{--                                    <li class="nav-item @if(Request::is('/settings/index#/home-page/user-manual') OR Request::is('/settings/index#/home-page/create-user-manual') OR Request::is('/settings/index#/home-page/edit-user-manual/*')) active @endif">--}}
{{--                                        <a class="nav-link" href="{{ url ('/settings/index#/home-page/user-manual') }}">--}}
{{--                                            <i class="fa fa-circle nav-icon"></i> {!! trans('messages.user_manual') !!}--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
                                    <li class="nav-item @if(Request::is('/settings/index#/home-page/home-page-content') OR Request::is('/settings/index#/home-page/create-home-page-content') OR Request::is('/settings/index#/home-page/edit-home-page-content/*')) active @endif">
                                        <a  class="nav-link" href="{{ url ('/settings/index#/home-page/home-page-content') }}">
                                            <i class="fa fa-circle nav-icon"></i> {!! trans('messages.home-page-content') !!}
                                        </a>
                                    </li>
                                    <li class="nav-item @if(Request::is('/settings/index#/home-page/industrial-city') OR Request::is('/settings/index#/home-page/create-industrial-city') OR Request::is('/settings/index#/home-page/edit-industrial-city/*')) active @endif">
                                        <a  class="nav-link" href="{{ url ('/settings/index#/home-page/industrial-city') }}">
                                            <i class="fa fa-circle nav-icon"></i> {!! trans('messages.industrial-city') !!}
                                        </a>
                                    </li>
                                    <li class="nav-item @if(Request::is('/settings/index#/home-page/home-page-articles') OR Request::is('/settings/index#/home-page/create-home-page-articles') OR Request::is('/settings/index#/home-page/edit-home-page-articles/*')) active @endif">
                                        <a class="nav-link" href="{{ url ('/settings/index#/home-page/home-page-articles') }}">
                                            <i class="fa fa-circle nav-icon"></i> {!! trans('messages.home-page-articles') !!}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item @if(Request::is('settings/maintenance-mode')) active @endif">
                                <a class="nav-link" href="{{ url ('settings/maintenance-mode') }}">
                                    <i class="fa fa-wrench fa-fw nav-icon"></i> {!! trans('messages.maintenance_mode') !!}
                                </a>
                            </li>
                            <li class="nav-item @if(Request::is('settings/app-rollback') || Request::is('settings/app-rollback-open')) active @endif">
                                <a class="nav-link" href="{{ url ('/settings/app-rollback') }}">
                                    <i class="fa fa-undo  nav-icon" aria-hidden="true"></i>
                                    App Rollback
                                </a>
                            </li>
                            <li class="nav-item @if(Request::is('settings/forcefully-data-update') || Request::is('settings/forcefully-data-update')) active @endif">
                                <a class="nav-link" href="{{ url ('settings/forcefully-data-update') }}">
                                    <i class="fa fa-database nav-icon" aria-hidden="true"></i>
                                    Forcefully data update
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if($type[0] == 2)
                <li class="nav-item {{ Request::is('settings/*') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="javascript:void(0)"
                       class="nav-link  {{ Request::is('settings/*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-wrench"></i>
                        <p>{!!trans('messages.support')!!}</p>
                        <i class="fas fa-angle-left right"></i>
                    </a>
                    <ul class="nav-item nav-treeview">


                        <li class="nav-item @if(Request::is('/settings/document-v2*')) active @endif">
                            <a class="nav-link" href="{{ url ('/settings/document-v2') }}">
                                <i class="fa fa-file fa-fw nav-icon" aria-hidden="true"></i>
                                <span>{!! trans('messages.document') !!}</span>
                            </a>
                        </li>

                        {{-- <li class="nav-item @if(Request::is('/settings/index#/notice') || Request::is('/settings/index#/create-notice') || Request::is('/settings/index#/edit-notice/*')) active @endif">
                            <a class="nav-link" href="{{ url ('/settings/index#/notice-list') }}">
                                <i class="fa fa-list-alt fa-fw nav-icon"></i> {!! trans('messages.notice') !!}
                            </a>
                        </li> --}}

                        <li class="nav-item @if(Request::is('/settings/index#/company-info') || Request::is('/settings/index#/company-info') || Request::is('/settings/index#/create-company') || Request::is('/settings/index#/rejected-company') || Request::is('/settings/index#/company-info-action/*')) active @endif">
                            <a class="nav-link" href="{{ url ('/settings/index#/company-info') }}">
                                <i class="fa fa-industry nav-icon" aria-hidden="true"></i>  {!! trans('messages.company_info') !!}
                            </a>
                        </li>

                        <li class="nav-item @if(Request::is('/settings/index#/pdf-print-requests') || Request::is('/settings/index#/get-pdf-print-requests') || Request::is('/settings/index#/edit-pdf-print-requests/*') || Request::is('/settings/index#/pdf-print-request-verify/*')) active @endif">
                            <a class="nav-link" href="{{ url ('/settings/index#/pdf-print-requests') }}">
                                <i class="fa fa-file-pdf  nav-icon" aria-hidden="true"></i>  {!! trans('messages.pdf-print-requests') !!}
                            </a>
                        </li>
                        <li class="nav-item @if(Request::is('/settings/index#/email-sms-queue') || Request::is('/settings/index#/email-sms-queue/*')) active @endif">
                            <a class="nav-link" href="{{ url ('/settings/index#/email-sms-queue') }}">
                                <i class="fa fa-sync  nav-icon" aria-hidden="true"></i>  {!! trans('messages.email_sms_queue') !!}
                            </a>
                        </li>

                        <li class="nav-item @if(Request::is('settings/forcefully-data-update') || Request::is('settings/forcefully-data-update')) active @endif">
                            <a class="nav-link" href="{{ url ('settings/forcefully-data-update') }}">
                                <i class="fa fa-database nav-icon" aria-hidden="true"></i>
                                Forcefully data update
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(in_array($type[0], [1]))
                    {{--                    <li class="@if (Request::is('custom-notification/*')) active @endif">--}}
                    {{--                        <a href="{{ url ('/custom-notification/list') }}">--}}
                    {{--                            <i class="fa fa-users fa-fw"></i> {!!trans('messages.batch_email')!!}--}}
                    {{--                        </a>--}}
                    {{--                    </li>--}}

                    <li class="nav-item {{ (Request::is('common/activities/activities-summary') ? 'active' : '') }}">
                        <a class="nav-link" href="{{ url ('/common/activities/activities-summary')}}"><i class="fa fa-list nav-icon"></i>
                            <span>
                            {!! trans('messages.activities_summary') !!}
                        </span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
