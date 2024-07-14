@extends('public_home.front')
@section('header-resources')
@endsection
@section('body')
    <main role="main">
        @include('public_home.slider')

        <section class="welcome-section section_padding"  id="LoginPortal">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="section-title">
                            <h2 class="ml-4">{{ App::isLocale('bn') ? $chairmanData->title : $chairmanData->title_en }}</h2>
                        </div>
                        <hr />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img class="welcome-image" alt="..." src="{{ $chairmanData->imag }}"
                                     onerror="this.src=`{{asset('/assets/images/default_profile.jpg')}}`"
                                >
                                
                            </div>

                            <div class="col-md-8 show-read-more">
                                {!! App::isLocale('bn') ? $chairmanData->details : $chairmanData->details_en !!}
                            </div>
                        </div>
                    </div>

                    @include('public_home.login_panel')
                </div>
            </div>
        </section>

        <section id="help_sec_hidden_mobile" class="help-section section_padding">
            <div class="container">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="section-title">
                            <h2 class="ml-4">{!! trans('messages.help_sec.title') !!}</h2>
                        </div>
                        <hr />
                    </div>
                </div>

                <div class="row">
                    @foreach ($necessaryInfo as $necessaryInfoData)
                        <div class="col-md-3 col-6 col-sm-6">
                            <div class="help_widget">
                                <div class="help_widget_header">
                                    {{-- <img alt='...' src="{{ $necessaryInfoData->image }}"> --}}

                                    <img src="{{ $necessaryInfoData->image }}"
                                         onerror="this.src=`{{asset('/assets/images/photo_default.png')}}`"
                                    alt='...' class="img-responsive">
                                </div>
                                <div class="help_widget_content">
                                    <h3>{{ App::isLocale('bn') ? $necessaryInfoData->heading : $necessaryInfoData->heading_en }}
                                    </h3>
                                </div>
                                <div class="help_widget_footer">
                                    <a href="{{ url($necessaryInfoData->details_url) }}">
                                        <button class="help_div">{!! trans('messages.see_more_btn') !!}</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>

        <section class="investment-section section_padding">
            <div class="container">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="section-title">
                            <h2 class="ml-4">{!! trans('messages.economic-zone') !!}</h2>
                        </div>
                        <hr />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card-body">
                           <div class="row">
                               <div class="col-md-6" style="padding-left: 0;">
                                   <img src="/assets/images/office_image.webp" alt="No image found" width="100%" height="300px">
                               </div>

                               <div class="col-md-6">
                                   <h3> বিজনেস অটোমেশন লিমিটেড</h3>
                                   <br>
                                   <h3>প্রধান কার্যালয়</h3>
                                   <h4>১৩৭-১৩৮,  কাওরান বাজার, ঢাকা-১০০০</h4>
                               </div>
                           </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="location_map">
                            <a target="_blank"
                               href="https://www.google.com/maps/place/%E0%A6%AC%E0%A6%BF%E0%A6%9C%E0%A6%A8%E0%A7%87%E0%A6%B8+%E0%A6%85%E0%A6%9F%E0%A7%8B%E0%A6%AE%E0%A7%87%E0%A6%B6%E0%A6%A8+%E0%A6%B2%E0%A6%BF%E0%A6%AE%E0%A6%BF%E0%A6%9F%E0%A7%87%E0%A6%A1/@23.7510515,90.3917325,17z/data=!4m5!3m4!1s0x3755b8a2acdd83c1:0xf294b0d4a07093a8!8m2!3d23.7509988!4d90.3930574"><img
                                    src="assets/images/map.webp" width="100%" style="max-height:300px" alt=""></a>
                            {{-- {!! (!empty($industrialMap->body)?$industrialMap->body:'') !!} --}}
                        </div>
                    </div>
                </div>


            </div>
        </section>


        <section class="informatics section_padding">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="section-title">
                            <h2 class="ml-4">{!! trans('messages.informatics') !!}</h2>
                        </div>
                        <hr/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-lg-3 col-6">
                        <div class="info_widget">
                            <div class="row">
                                <div class="col-md-5 col-xs-6 col-sm-6">
                                    <div class="info_widget_left purple">
                                        {{--                                <img src="{{ asset('assets/images/informatics1.png') }}">--}}
                                        <i class="fa fa-industry fa-1x"></i>
                                    </div>
                                </div>
                                <div class="col-md-7 col-xs-6 col-sm-6">
                                    <div class="info_widget_right mt-3">
                                        <h1 class="{{ App::isLocale('bn') ? 'input_ban' : '' }}">{{$CityData}}</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center info_widget_footer">
                                    <p>{!! trans('messages.informatics_sec.no_of_eco_zone') !!}</p></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3 col-6">
                        <div class="info_widget">
                            <div class="row">
                                <div class="col-md-5 col-xs-6 col-sm-6">
                                    <div class="info_widget_left shamrock">
                                        {{--                                <img src="{{ asset('assets/images/informatics2.png') }}">--}}
                                        <i class="fa fa-building fa-1x"></i>
                                    </div>
                                </div>
                                <div class="col-md-7 col-xs-6 col-sm-6">
                                    <div class="info_widget_right mt-3">
                                        <h1 class="{{ App::isLocale('bn') ? 'input_ban' : '' }}">{{$total_stakeholder}}</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center info_widget_footer">
                                    <p>{!! trans('messages.informatics_sec.no_of_company') !!}</p></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3 col-6">
                        <div class="info_widget">
                            <div class="row">
                                <div class="col-md-5 col-xs-6 col-sm-6">
                                    <div class="info_widget_left danube">
                                        {{--                            <img src="{{ asset('assets/images/informatics3.png') }}">--}}
                                        <i class="fa fa-cogs fa-1x"></i>
                                    </div>
                                </div>
                                <div class="col-md-7 col-xs-6 col-sm-6">
                                    <div class="info_widget_right">
                                        <h1 class="{{ App::isLocale('bn') ? 'input_ban' : '' }}">{{$processType}}</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center info_widget_footer">
                                    <p>{!! trans('messages.informatics_sec.no_of_services') !!}</p></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3 col-6">
                        <div class="info_widget">
                            <div class="row">
                                <div class="col-md-5 col-xs-6 col-sm-6">
                                    <div class="info_widget_left orange">
                                        {{--                            <img src="{{ asset('assets/images/informatics4.png') }}">--}}
                                        <i class="fa fa-envelope fa-1x"></i>
                                    </div>
                                </div>
                                <div class="col-md-7 col-xs-6 col-sm-6">
                                    <div class="info_widget_right mt-3">
                                        <h1 class="{{ App::isLocale('bn') ? 'input_ban' : '' }}">{{$serviceList}}</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center info_widget_footer">
                                    <p>{!! trans('messages.informatics_sec.no_of_delivered_services') !!}</p></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{--            <div class="row">--}}
                {{--                <div class="col-sm-12">--}}
                {{--                    <div class="text-center" id="applicationChartLoading">--}}
                {{--                        <i class="fa fa-spinner fa-pulse fa-3x"></i>--}}
                {{--                    </div>--}}
                {{--                    <div id="showApplicationChart"></div>--}}
                {{--                </div>--}}
                {{--            </div>--}}
            </div>
        </section>


    </main>
@endsection


@section('footer-script')
    {{-- <script src="{{ asset('assets/plugins/swiper-bundle.js') }}"></script> --}}
    {{--ob#code@start (if posibble use one script tags - arif--}}
    <script>
        $('.carousel').carousel()
    </script>
    {{--ob#code@end - arif--}}
    <script>
        // Youtube video on click
        $('#video_modal').on('shown.bs.modal', function(e) {
            if (!$('.bscic_video').hasClass('has_video')) {
                $('.bscic_video').addClass('has_video').append('{!! !empty($bscicDocumentary->body) ? $bscicDocumentary->body : '' !!}');
            }

        })
        $('#video_modal').on('hidden.bs.modal', function(e) {
            $("#video_modal iframe").attr("src", $("#video_modal iframe").attr("src"));
        })
    </script>
@endsection
