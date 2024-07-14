@extends('public_home.front')
@section('header-resources')
@endsection
@section('body')
    <main role="main">
        {{-- Banner --}}
        @include('frontend.pages.banner')
        
        {{-- Notice --}}
        <section class="container">
            <marquee class="notice_sec p-3">
                <span class="">NOTICE:</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown prin .......
            </marquee>
        </section>
        <section class="populer_courses_sec pb-5 pt-2    container">
            <div class="populer_courses">
                <div class="section_heading">
                    <h2>About Our Courses </h2>
                    <p>
                        We have designed our courses with the most demanding professional skills. The knowledge,
                        experience,
                        and expertise gained through the program will ensure your desired job in the global market. From
                        the list
                        below you can enroll to any online or offline courses at any time.
                    </p>
                    <div class="input-group">
                        <input type="text" class="form-control search-input"
                            aria-label="Text input with dropdown button" placeholder="Search">
                        <div class="input-group-append">
                            <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <div class="dropdown-menu" style="width: 340px;">
                                <div class="col-md-12">
                                    <form class="">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select class="form-control required" id="division" name="division">
                                                        <option selected="selected" value=""> বিভাগ নির্বাচন</option>
                                                        <option value="11">বরিশাল</option>
                                                        <option value="14">চট্রগ্রাম</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="form-control required" id="district" name="district">
                                                        <option selected="selected" value=""> জেলা নির্বাচন</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <select class="form-control" id="office" name="office">
                                                        <option selected="selected" value="">অফিস নির্বাচন করুন</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <select class="form-control" id="course" name="course">
                                                        <option selected="selected" value="">কোর্স নির্বাচন করুন</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
    
                                        <button type="button" class="btn btn-primary col-md-offset-5 filter"><span class="fa fa-filter"></span> Filter
                                        </button>
                                    </form>
                                </div>
                              </div>
                            <button type="button" class="btn search-btn">
                                <img src="{{asset('/assets/images/search.png')}}" alt="Iocn" class="mb-1">
                                Search</button>
                        </div>
                    </div>
                </div>
                
                {{-- course_tab --}}
                <div class="container">
                    <div id="list_8" class="tab-pane">
                        <div class="box box-solid no-margin">
                            <div class="box-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs custom_nav col-md-12 d-flex justify-content-around border-bottom mb-5" role="tablist">
                                    <li class="nav-item" role="presentation" id="upcoming" onclick="loadData(this.id)">
                                        <a class="nav-link active dynamic_tab course-mix" id="upcoming-tab" data-toggle="tab" href="#upcoming" role="tab" aria-controls="upcoming" aria-selected="true">Up-coming Course</a>
                                    </li>
                                    <li class="nav-item" role="presentation" id="ongoing" onclick="loadData(this.id)">
                                        <a class="nav-link dynamic_tab course-mix" id="ongoing-tab " data-toggle="tab" href="#ongoing" role="tab" aria-controls="ongoing" aria-selected="false">On-going Course</a>
                                    </li>
                                    <li class="nav-item" role="presentation" id="close" onclick="loadData(this.id)">
                                        <a class="nav-link dynamic_tab course-mix" id="close-tab " data-toggle="tab" href="#close" role="tab" aria-controls="close" aria-selected="false">Closed Course</a>
                                    </li>
                                    <li class="nav-item" role="presentation" id="allCourse" onclick="loadData(this.id)">
                                        <a class="nav-link dynamic_tab course-mix" id="allCourse-tab" data-toggle="tab" href="#allCourse" role="tab" aria-controls="training-course" aria-selected="false">All Course</a>
                                    </li>
                                </ul>

                                <br>
                                <!-- Nav tabs Content Loaded -->
                                <div id="load_content">
                                    <div class="tab-content" id="content">



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--#/list_8-->
                </div><!--./container-->

                <div class="text-center">
             <a href="{{ route('courseViewMore') }}" class="view-more text-decoration-none" style="	color: #381691;">View More</a>
                    <img src="{{asset('/assets/images/arrow.png')}}" alt="Iocn" class="mb-1">
                </div>
            </div>
        </section>


    </main>
@endsection


@section('footer-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadData('upcoming');
        });

        function loadData(id) {
            var url = "{{ url('web/get-training-data') }}";
            var data = {
                status: id
            };
            $.ajax({
                url: url,
                type: 'GET',
                data: data,
                beforeSend: function() {
                    $('#content').html(
                        '<div class="row"><div class="col-md-12"><h3 class="text-center text-info">Loading...<i class="fa fa-spinner fa-spin"></i></h3></div></div>'
                    );
                },
                success: function(response) {
                    if(response == ''){
                        // toastr.options = {
                        //     positionClass: "toast-bottom-right",
                        // }
                        // toastr.error('<b>No data found</b>');
                        $('#content').html(
                            '<div class="row"><div class="col-md-12"><h3 class="text-center text-info">No Data Found</h3></div></div>'
                        );
                    }
                    else{
                        $('#content').html(response);
                    }
                }
            });
        }

        $("#filter").on('click', function() {
            var txtSearch = $("#txtSearch").val();
            if (txtSearch == '') {
                toastr.options = {
                    positionClass: "toast-bottom-right",
                }
                toastr.error('<b>Please enter course title</b>');
                return false;
            }

            $.ajax({
                type: "GET",
                url: "{{ url('web/training/filter-data') }}",
                data: {
                    txtSearch: txtSearch,
                },
                beforeSend: function() {
                    $('#content').html(
                        '<div class="row"><div class="col-md-12"><h3 class="text-center text-info">Loading...<i class="fa fa-spinner fa-spin"></i></h3></div></div>'
                    );
                },
                success: function(response) {
                    if (response == '') {
                        toastr.options = {
                            positionClass: "toast-bottom-right",
                        }
                        toastr.error('<b>No data found</b>');
                        $('#content').html(
                            '<div class="row"><div class="col-md-12"><h3 class="text-center text-info">No Data Found</h3></div></div>'
                        );
                    }
                    else{
                        $('#content').html(response);
                    }
                }
            });
        });
    </script>

    

@endsection

