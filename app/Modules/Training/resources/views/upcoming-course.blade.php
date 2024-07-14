<?php

use App\Libraries\Encryption;
use Illuminate\Support\Facades\Auth;

$user_type = Auth::user()->user_type;
$desk_training_ids = Auth::user()->desk_training_ids;
?>
@extends('layouts.admin')

@section('header-resources')
    <style>

        .btn {
            font-size: 16px;
        }

        .site-header .navbar-toggler:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        /*  course heading  */
        .course-mix {
            color: #1F1E1E;
            text-align: center;
            font-size: 16px;
            font-style: normal;
            font-weight: 700;
            border: none;
            background: #faf9fd;
            padding: 14px 0px 17px 0px !important;

        }

        .course-mix.active {
            color: #CF0000;
            border-bottom: 3px solid #CF0000;

        }

        /*  course details  */

        .info-item {
            display: block;
            margin-bottom: 5px;
        }

        .info-item.heading {
            color: #DF6812;
            font-size: 14px;
            font-style: normal;
            font-weight: 700;
        }

        .info-item.detail {
            font-family: "Segoe UI";
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
        }

        .info-item.student {
            color: #787A82;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
        }

        .course-details {
            border-radius: 25px !important;
            border: 1px solid rgba(0, 0, 0, 0.10) !important;
            background: #FFF;
        }

        .course-details img {
            border-top-left-radius: 25px !important;
            border-top-right-radius: 25px !important;
        }

        .course {
            display: flex;
            padding: 0px 14px 28px 17px;
            flex-direction: row;
            align-items: flex-start;
            gap: 55px;
            align-self: stretch;
        }

        .details-btn {
            border-radius: 8px;
            border: 1px solid #FF7E31;
            color: #8C0000;
            text-align: center;
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
            padding: 7px 8px 9px 8px;
            background-color: white;

        }
        .course-fee {
            color: #00684D;
            font-size: 16px;
            font-style: normal;
            font-weight: 700;
            line-height: 30px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }
        .card-title{
            font-size: 1.5rem;
            font-weight: 500;
            line-height: 24px;
            margin-bottom: .75rem;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }
        .details-btn{
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }
    </style>
@endsection

@section('content')
    @include('partials.messages')
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 px-5">
        @if ($course->count() > 0)
            @foreach ($course as $row)
                <div class="col mb-4">
                    <div class="card course-details">
                        <img src="{{ asset('/uploads/training/course/' . $row->course_thumbnail_path) }}"
                            class="card-img-top" alt="{{ $row->course->course_title }}"
                            onerror="this.src=`{{ asset('/assets/images/no-image.png') }}`"
                            title="{{ $row->course->course_title }}" />

                        <div class="card-body">
                            <h4 class="card-title">{{ $row->course->course_title }}</h4>
                            <?php
                            $enroll_deadline = strtotime($row->enroll_deadline);
                            $current_date = strtotime(date('Y-m-d'));
                            ?>
                            @if ($enroll_deadline >= $current_date)
                                <span class="info-item detail">Registration Ends:
                                    {{ date('d M', $enroll_deadline) }}</span>
                            @else
                                <span class="text-danger info-item detail">Registration Closed</span>
                            @endif
                            <span class="info-item detail">Location :
                                {{ $row->thana->area_nm . ', ' . $row->district->area_nm }}</span>
                            {{-- <span class="info-item student">5,200 Student</span> --}}
                        </div>
                        <div class="course d-flex justify-content-between">
                            <div class="course-fee">Free</div>
                            <a href="{{ url('training/course-details/' . \App\Libraries\Encryption::encodeId($row->id)) }}"
                                class="details-btn" style="font-size: 13px;text-decoration: none; color: #8C0000;">
                                {{ $row->enroll_deadline >= date('Y-m-d') ? 'Details' : 'Open' }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row col-12 text-center">
                <div class="alert alert-info">
                    <strong>Info!</strong> No upcoming course available.
                </div>
            </div>
        @endif
    </div><!-- /.col-lg-12 -->

    <div class="row">
        <div class="col-md-12 text-center">
            {{-- {!! $course->links() !!} --}}
        </div><!--./col-md-offset-5-->
    </div><!--./row-->
@endsection <!--content section-->

@section('footer-script')
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection <!--- footer-script--->
