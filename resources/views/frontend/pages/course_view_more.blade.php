@extends('public_home.front')
@section('body')
<main class="site-main-content page-height">
    <div class="npo-breadcrumb" style="background-color: white;">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            <span class="bcm-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                                    fill="none">
                                    <path
                                        d="M7.30975 1.00158C7.26911 0.960836 7.22083 0.928511 7.16768 0.906455C7.11453 0.8844 7.05755 0.873047 7 0.873047C6.94245 0.873047 6.88547 0.8844 6.83232 0.906455C6.77917 0.928511 6.73089 0.960836 6.69025 1.00158L1.44025 6.25158C1.39965 6.29228 1.36747 6.34059 1.34555 6.39374C1.32363 6.44689 1.3124 6.50384 1.3125 6.56133V12.6863C1.3125 12.8024 1.35859 12.9136 1.44064 12.9957C1.52269 13.0777 1.63397 13.1238 1.75 13.1238H5.6875C5.80353 13.1238 5.91481 13.0777 5.99686 12.9957C6.07891 12.9136 6.125 12.8024 6.125 12.6863V9.18633H7.875V12.6863C7.875 12.8024 7.92109 12.9136 8.00314 12.9957C8.08519 13.0777 8.19647 13.1238 8.3125 13.1238H12.25C12.366 13.1238 12.4773 13.0777 12.5594 12.9957C12.6414 12.9136 12.6875 12.8024 12.6875 12.6863V6.56133C12.6876 6.50384 12.6764 6.44689 12.6545 6.39374C12.6325 6.34059 12.6004 6.29228 12.5598 6.25158L11.375 5.0677V2.18633C11.375 2.0703 11.3289 1.95902 11.2469 1.87697C11.1648 1.79492 11.0535 1.74883 10.9375 1.74883H10.0625C9.94647 1.74883 9.83519 1.79492 9.75314 1.87697C9.67109 1.95902 9.625 2.0703 9.625 2.18633V3.3177L7.30975 1.00158ZM2.1875 12.2488V6.74245L7 1.92995L11.8125 6.74245V12.2488H8.75V8.74883C8.75 8.6328 8.70391 8.52152 8.62186 8.43947C8.53981 8.35742 8.42853 8.31133 8.3125 8.31133H5.6875C5.57147 8.31133 5.46019 8.35742 5.37814 8.43947C5.29609 8.52152 5.25 8.6328 5.25 8.74883V12.2488H2.1875Z"
                                        fill="#0D6EFD" />
                                </svg>
                            </span> Home
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Course Details</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <section class="container">
        {{-- course_tab --}}
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