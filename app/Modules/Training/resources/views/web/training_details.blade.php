@extends('public_home.front')

@section('header-resources')
<style>
    .training_course_details_sec h5 {
        margin: 0;
    }

    .training_course_details_sec .panel {
        border-radius: 5.948px;
        border: 1px solid #5FC5E0;
        background: #FFF;
        box-shadow: 0px 3.569px 9.517px 0px rgba(0, 0, 0, 0.24);
    }

    .training_course_details_sec .panel-default {
        border-color: #5FC5E0;
    }

    .training_course_details_sec .panel-body {
        padding: 0;
    }

    .training_course_details_sec .training_course_details_title {
        color: #333;
        font-size: 22px;
        font-style: normal;
    }

     .training_course_details_office span {
        color: #333;
        font-family: SolaimanLipi;
        font-size: 17.427px;
        font-style: normal;
    }
    .training_course_details_office span u {
        color: #333;
        font-family: SolaimanLipi;
        font-size: 17.427px;
        font-style: normal;
    }
    .training_course_details_sec .training_course_details_img {
        padding: 10px 12px 0 12px;
    }

    .training_course_details_sec .training_course_details_img img {
        width: 100%;
        height: 150px;
    }
 .training_course_details_text span{
        color: #333;
        font-family: SolaimanLipi;
        font-size: 20.224px;
        font-style: normal;
        font-weight: 400;
    }
.training_course_details_text .fee{
    color: #3C763D;
}
    .training_course_details_sec .training_course_details_data {
        padding: 0 0 0 12px;
    }

    .training_course_details_sec .training_course_details_apply_div {
        padding-right: 12px;
    }

    .training_course_details_sec .training_course_details_apply,  .training_course_details_sec .training_course_details_apply:hover {
        color: #FFFFFF !important;
        border-radius: 3.569px;
        background: #381691;
    }

    .training_course_details_apply_div a:hover{
        color: #FFFFFF !important;
        border-radius: 3.569px;
        background: #381691;
    }


    /* width */
    .training_course_description_sec ::-webkit-scrollbar {
        width: 10px;
    }

    /* Track */
    .training_course_description_sec ::-webkit-scrollbar-track {
        background: #f1f1f1; 
    }
    
    /* Handle */
    .training_course_description_sec ::-webkit-scrollbar-thumb {
        border-radius: 5px;
        background: #b0b0b0; 
    }

    /* Handle on hover */
    .training_course_description_sec ::-webkit-scrollbar-thumb:hover {
        background: #6d6d6d; 
    }

    /** end -:- training_course_details_sec **/

    /** start -:- training_course_coordinator_sec **/

    .training_course_coordinator_sec h5 {
        color: #333;
        font-family: SolaimanLipi;
        font-size: 20.74px;
    }

    .training_course_coordinator_sec h6 {
        color: #333;
        font-family: SolaimanLipi;
        font-size: 17.994px;
        font-style: normal;
        font-weight: 700;
    }
    .training_course_coordinator_sec .panel {
        border-radius: 5.948px;
        border: 1px solid #5FC5E0;
        background: #FFF;
        box-shadow: 0px 3.569px 9.517px 0px rgba(0, 0, 0, 0.24);
    }

    .training_course_coordinator_sec .panel-body {
        padding: 0;
        height: 350px;
    }

    .training_course_coordinator_sec .course_coordinator_img_div {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .training_course_coordinator_sec .course_coordinator_img {
        height: 120px;
        width: 120px;
    }
    .training_course_coordinator_sec span{
        color: #333;
        text-align: center;
        font-family: SolaimanLipi;
        font-size: 17.399px;
        font-weight: 400;
    }

    /** end -:- training_course_coordinator_sec **/

    /** start -:- training_course_venue_sec **/
    /* .training_course_venue_sec {}

    .training_course_venue_sec .panel {
        border-radius: 5px;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        background-color: #FEFEFE;
    }

    .training_course_venue_sec .panel-default {
        border-color: #5FC5E0;
    }

    .training_course_venue_sec .panel-body {}

    .training_course_venue_sec .training_course_venue_title {
        padding: 10px 0 10px 30px;
    }

    .training_course_venue_sec .training_course_venue_title h3 {
        margin: 0;
    }

    .training_course_venue_sec .training_course_venue {
        padding: 10px 0 10px 30px;
    }

    .training_course_venue_sec .training_course_venue h5 {
        font-size: 17px;
        margin: 0;
    }

    .training_course_venue_sec .training_course_center_image img {
        width: 100%;
        height: 220px;
        background-position: center;
        background-size: 100% 100%;
    } */

    /** end -:- training_course_venue_sec **/

    /** start -:- training_course_description_sec **/
    .training_course_description_sec {
        width: 100%;
    }

    .training_course_description_sec .panel {
        border-radius: 5.948px;
        border: 1px solid #5FC5E0;
        background: #FEFEFE;
        box-shadow: 0px 3.569px 9.517px 0px rgba(0, 0, 0, 0.24);
    }

    .training_course_description_sec .panel-body {
        padding-left: 30px;
        padding-right: 30px;
        height: 450px;
        overflow: auto;
    }

    .participant_qualifications{
        font-family: SolaimanLipi;
        font-size: 28px;
        font-weight: 700;
    }

    .outcome-details{
        color: #333;
        font-family: SolaimanLipi;
        font-size: 16.655px;
        font-style: normal;
        font-weight: 400;
    }

    .qualification-details{
        color: #333;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
    }
    /** end -:- training_course_description_sec **/


    /** start -:- training_course_schedule_sec **/
    .training_course_schedule_sec {
        width: 100%;
        background: white;
    }

    .training_course_schedule_sec .panel {
        border-radius: 5.948px;
        border: 1px solid #5FC5E0;
        background: #FFF;
        box-shadow: 0px 3.569px 9.517px 0px rgba(0, 0, 0, 0.24);
    }

    .training_course_schedule_sec .training_course_schedule_title {
        padding-left: 30px;
    }

    .training_course_schedule_sec .training_course_schedule_border {
        border-top: 1px solid #1329B0;
        margin-left: 30px;
        margin-right: 30px;
    }

    .training_course_schedule_sec .table-responsive {
        padding: 15px 30px 0;
    }

    /** end -:- training_course_schedule_sec **/
    .other_location_program_title {

        padding: 15px 0 15px 0;
    }

    .other_location_program_title h2 {
        color: #249954;
        font-size: 28px;
        margin: 0;
        font-weight: bold;
    }

    .load_upcoming_course_in_office_btn {
        padding-bottom: 15px;
    }

    .load_upcoming_course_in_office_btn button {
        background-color: #472A6D;
        color: #FFFFFF;
        padding: 5px 10px;
        border-radius: 10px;
    }

    .padding_top_20 {
        padding-top: 20px;
    }

    .padding_top_10 {
        padding-top: 10px;
    }

    .padding_top_25 {
        padding-top: 25px !important;
    }

    .course_suggestion_section {
        padding-top: 15px;
        background: white;
    }

    .course_suggestion_section .panel {
        border-radius: 5px;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    }

    .course_suggestion_section .panel-default {
        border-color: #5FC5E0;
    }

    .course_suggestion_section .panel-body {
        padding: 0;
    }

    .course_suggestion_section .course_suggestion_image {
        padding-top: 15px;
        padding-left: 15px;
        padding-right: 15px;
    }

    .course_suggestion_section .course_suggestion_image img {
        width: 100%;
        height: 25vh;
        border-radius: 10px;
    }

    .course_suggestion_section .course_suggestion_panel_data {
        padding-left: 15px;
    }

    .course_suggestion_section .course_suggestion_title {
        height: 80px;
    }

    .course_suggestion_section .course_suggestion_title h2 {
        font-size: 18px;
        margin: 0;
        padding: 20px 0 0 0
    }

    .course_suggestion_section .course_suggestion_title h3 {
        font-size: 18px;
        margin: 0;
        padding: 10px 0 0 0
    }

    .course_suggestion_section .course_suggestion_seat {
        padding: 15px 0 0 0;
        /*background-color: #34A569;*/
    }

    .course_suggestion_section .course_suggestion_seat span {
        font-size: 16px;
        color: #34A569;
        font-weight: bold;
    }

    .course_suggestion_section .course_suggestion_office span {
        font-size: 16px;
    }

    .course_suggestion_section .course_suggestion_reg_date span {
        font-size: 16px;
    }

    .course_suggestion_section .course_suggestion_reg_date {
        padding-bottom: 20px;
    }

    .course_suggestion_section .course_suggestion_apply_btn {
        padding-bottom: 20px;
    }

    .course_suggestion_section .course_suggestion_apply_btn a {
        background-color: #34A569;
        color: #FFFFFF;
    }

    .course_suggestion_section .course_suggestion_apply_btn a:hover {
        background-color: #25b669;
        color: #FFFFFF;
    }

    @media screen and (max-width: 474px) {
        .other_location_program_title h2 {
            text-align: center;
        }

        /** end -:- (Screen Less Than 374) **/
    }

    @media screen and (max-width: 374px) {
        .other_location_program_title h2 {
            text-align: center;
        }

        /** end -:- (Screen Less Than 374) **/
    }

    #myModal .modal-dialog-centered {
        margin-top: 10%;
    }

    #myModal .modal-body {
        padding: 100px 0 100px 0;
    }

    #myModal .training_details_modal_context p {
        margin: 0;
    }

    #myModal .training_details_modal_context {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        gap: 15px;
    }

    #myModal .modal_login_btn {
        background-color: #30A31F;
        color: #FFFFFF;
        padding: 3px 35px;
    }

    #myModal .training_details_modal_create a {
        color: blue;
        font-weight: bold;
    }

    a,
    a:visited,
    a:hover,
    a:active {
        color: inherit;
    }
</style>
@endsection

@section ('body')
    <section id="webPortalTrainingDetailsSec">
        <div class="npo-breadcrumb">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/">
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
                        <li class="breadcrumb-item active" aria-current="page">{{ $course->course->course_title }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container my-4">
            <div class="row">
         
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="training_course_details_sec">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="training_course_details_img">
                                    <figure>
                                        <img src="{{ asset('uploads/training/course/' . $course->course_thumbnail_path) }}"
                                            class="img-responsive img-rounded" alt="..."
                                            onerror="this.src=`{{ asset('/assets/images/photo_default.png') }}`">
                                    </figure>
                                </div>
                                <div class="training_course_details_data">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="training_course_details_title">{{ $course->course->course_title }}</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="training_course_details_office pt-4 pb-2">
                                                        <span>Office Name :
                                                      <u>{{ $course->venue }}</u></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="training_course_details_text py-1">
                                                <span>Orientation</span>
                                                <span>{{ date('d M Y', strtotime($course->course_duration_start)) }}</span>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="training_course_details_text">
                                                <span>Class Start:</span>
                                                <span>{{ date('d M Y', strtotime($course->course_duration_start)) }}</span>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="training_course_details_text py-1">
                                                <?php
                                                    $enroll_deadline = strtotime($course->enroll_deadline);
                                                    $current_date = strtotime(date('Y-m-d'));
                                                ?>
                                                @if($enroll_deadline >= $current_date)
                                                    <span>Registration Ends:</span>
                                                    <span>{{ date('d M Y', strtotime($course->enroll_deadline)) }}</span>
                                                @else
                                                    <span class="text-danger">Registration Closed</span>
                                                @endif
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="training_course_details_text">
                                                <span class="fee"> Fee:</span>
                                                <span class="fee">{{ $course->fees_type == 'paid' ? $course->amount . ' Taka' : 'FREE' }}</span>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="padding_top_20"></div>
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <div class="training_course_details_apply_div float-right">
                                                <a href="{{ $redirect_url }}" type="button"
                                                class="btn pull-right training_course_details_apply">
                                                @if ($course->enroll_deadline >= date('Y-m-d') && $course->status == 'upcoming' && $course->is_publish == 1 && $course->is_active == 1)
                                                    Apply
                                                @else
                                                    View Details
                                                @endif
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="padding_top_20"></div>
                                </div>
                            </div>
                        </div>
                    </div><!--./training_course_details_sec-->
                </div>

                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="training_course_description_sec">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 participant_qualifications pt-4">
                                        <h3>Pre qualifications of Participant</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 qualification-details">
                                        {!! $course->necessary_qualification_experience ? $course->necessary_qualification_experience : 'Not Needed' !!}
                                    </div>
                                </div>
                                <hr>                                        
                                <div class="row">
                                    <div class="col-md-12 participant_qualifications">
                                        <h3>Training Outlines and Outcomes</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 outcome-details">
                                        {!! $course->objectives !!}
                                    </div>
                                </div>
                                {{-- <div class="training_course_description_border"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3><strong>Course Description</strong></h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! $course->course->course_description !!}
                                    </div>
                                </div>
                                 <div class="training_course_description_border"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3><strong>Course Outline</strong></h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! $course->course_contents !!}
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div><!--./training_course_description_sec-->
                </div>
            </div><!-- ./row (main)-->

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <div class="training_course_venue_sec">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="training_course_venue_title">
                                                    <h3><strong>প্রশিক্ষণ স্থান</strong></h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="training_course_venue">
                                                    <h5>{{ $course->training_center }}</h5>
                                                </div>
                                            </div>
                                        </div><!--/.row-->
                                    </div><!--/.panel-body-->
                                    <div class="training_course_center_image">
                                        <img src="https://ossbscic.gov.bd/uploads/training/BSCIC_TR-65473463336a56.12695556.jpeg">
                                    </div><!--/.training_course_center_image-->
                                </div><!--/.panel-->
                            </div><!--./training_course_venue_sec-->
                        </div>
                    </div> --}}
                    <div class="training_course_coordinator_sec my-3">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 text-center pt-4">
                                        <h5>Course Coordinator</h5>
                                    </div>
                                </div>
                                <div class="row py-3">
                                    <div class="col-md-12 text-center course_coordinator_img_div">
                                        <img src="{{ asset('users/profile-pic/' . $course->coordinator->user_pic) }}" class="rounded-circle" alt="..." style="height: 144px">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <h6>{{$course->coordinator->user_first_name ?? ''}}</h6>
                                        <span>{{$course->coordinator->designation ?? ''}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <span>Mobile : </span><span class="input_ban">{{$course->coordinator->user_mobile ?? ''}}</span>
                                     <br>
                                         <span>Email : </span><span>{{$course->coordinator->user_email ?? ''}}</span>
                               
                                    </div>
                                </div>
                                <div class="padding_top_25"></div>
                            </div>
                        </div>
                    </div><!--./training_course_details_sec-->

                </div><!-- ./col-lg-8 col-md-8 col-sm-12 col-xs-12 -->

                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <div class="training_course_schedule_sec mt-3">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="training_course_schedule_title  participant_qualifications pt-4">
                                                    <h3>Class Schedule</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="training_course_schedule_border"></div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 30%;" class="">Day</th>
                                                                <th style="width: 30%;" class="">Time</th>
                                                                <th style="width: 10%;" class="">Location</th>
                                                                <th style="width: 20%;" class="">Available Seat</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($scheduleSession as $row)
                                                                <tr>
                                                                    <td style="width: 25%" class="">
                                                                        <span>{{ $row->session_days }}</span>
                                                                    </td>
                                                                    <td style="width: 25%" class="">
                                                                        <span>{{ date('h:i a', strtotime($row->session_start_time)) }}
                                                                            -
                                                                            {{ date('h:i a', strtotime($row->session_end_time)) }}</span>
                                                                    </td>
                                                                    <td style="width: 25%;" class=" input_ban">
                                                                        {{ $course->venue ?? ''}}

                                                                    </td>
                                                                    <td style="width: 25%;" class=" input_ban">
                                                                        {{ $row->seat_capacity == 0 ? 'Unlimited' : $row->seat_capacity }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--./training_course_schedule_sec-->
                        </div><!--./col-md-12 (Course Schedule)-->
            </div>
            <!-- start -:- Suggestion Course -->
{{-- 
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="other_location_program_title">
                        <h2>More training on {{ $course->category->category_name }}</h2>
                    </div>
                </div>
            </div> --}}
            <!--./row-->
{{-- 
            <div class="row">
                        @foreach ($courseList as $row)
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <div class="course_suggestion_section">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="course_suggestion_image">
                                                <img src="{{ asset('/uploads/training/course/' . $row->course_thumbnail_path) }}"
                                                    class="img-responsive" alt="{{ $row->course->course_title }}"
                                                    onerror="this.src=`{{ asset('/assets/images/photo_default.png') }}`"
                                                    title="{{ $row->course->course_title }}">
                                            </div>
                                            <div class="course_suggestion_panel_data">
                                                <div class="course_suggestion_title">
                                                    <h2 title="SM-202404000030"><strong>{{ $row->course->course_title }}</strong></h2>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="course_suggestion_seat">
                                                            <span>আসন :</span>
                                                            <span>অনির্ধারিত</span>
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="course_suggestion_office">
                                                            <span class="training_course_details_title">Course Venue :</span>
                                                            <span>{{ mb_substr($row->venue, 0, 40, 'UTF-8') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="course_suggestion_reg_date" style="padding-bottom: 5px;">
                                                            <span>Class Start Date:</span>
                                                            <span>{{ date('d F Y', strtotime($row->course_duration_start)) }}</span>
                                                        </div>
                                                    </div>

                                                    <?php
                                                        $enroll_deadline = strtotime($row->enroll_deadline);
                                                        $current_date = strtotime(date('Y-m-d'));
                                                    ?>
                                                    <div class="col-md-12">
                                                        <div class="course_suggestion_reg_date">
                                                            @if($enroll_deadline >= $current_date)
                                                            <span>Last date of registration:</span>
                                                            <span>{{ $row->enroll_deadline }}</span>
                                                            @else
                                                            <span class="text-danger">Registration Closed</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($row->enroll_deadline >= date('Y-m-d') && $row->status == 'upcoming' && $row->is_publish == 1 && $row->is_active == 1)
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="course_suggestion_apply_btn text-center">
                                                            <a href="{{ $redirect_url }}" class="btn">Apply now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="course_suggestion_apply_btn text-center" style="height: 53px;">
                                                            <a href="{{ $redirect_url }}" class="btn">View Details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div><!--./course_suggestion_panel_data-->
                                        </div><!--./panel-body-->
                                    </div><!--./panel-->
                                </div><!--./course_suggestion_section-->
                            </div><!--./col-->
                        @endforeach
            </div> --}}
      

            {{-- <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <div class="load_upcoming_course_in_office_btn">
                        <button id="loadUpcomingCourseInDistrictBtn" onclick="loadUpComingCourseDistrict()"
                            style="display: none;">See More &nbsp;<i class="fa fa-arrow-circle-down"></i></button>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="other_location_program_title">
                    </div>
                </div>
            </div><!--./row-->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
                    <div id="loadUpcomingCourseInOffice" class="training_card_grid"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <div class="load_upcoming_course_in_office_btn">
                        <button id="loadUpcomingCourseInOfficeBtn" onclick="loadUpcomingCourseInOffice()"
                            style="display: none;">আরো দেখুন &nbsp;<i class="fa fa-arrow-circle-down"></i></button>
                    </div>
                </div>
            </div>
            <div class="row" id="loadUpcomingCourseCategory"></div> --}}
            <!-- end -:- Suggestion Course -->
        </div><!-- ./container (main)-->
    </section>
@endsection
