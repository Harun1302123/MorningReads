@extends('layouts.admin')

@section('header-resources')
@endsection

@section('content')
    @include('partials.messages')

    @if (Auth::user()->is_approved != 1 or Auth::user()->is_approved != true)
    {{-- 
        ob#code@start - Harun - message/un-approved file directory not found
        ob#code@end - Harun  
    --}}
        @include('message.un-approved')
    @else
        <div class="row">
            <div class="col-md-12">
                @if (isset($user_multiple_company) == 1 && in_array(Auth::user()->user_type, ['5x505', '6x606']))
                    @include('CompanyAssociation::working-company-modal')
                @else
                    @include('Dashboard::dashboard')
                @endif
            </div>
        </div>
    @endif
@endsection

@section('footer-script')
    @yield('chart_script')
@endsection
