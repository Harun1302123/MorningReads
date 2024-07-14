<?php
    if (!ACL::getAccsessRight('Training-Desk', '-V-')) {
        die('You have no access right! Please contact system administration for more information');
    }
?>


@extends('layouts.admin')

@section('page_heading', trans('messages.rollback'))

@section('content')
    <style>
        .label-upcoming {
            background-color: #f0ad4e;
            color: #fff;
            cursor: pointer;
        }

        .label-ongoing {
            background-color: #5cb85c;
            color: #fff;
            cursor: pointer;
        }

        .label-completed {
            background-color: #5bc0de;
            color: #fff;
            cursor: pointer;
        }

        .label-upcoming:hover {
            background-color: #eda33b;
            color: #fff;
        }

        .label-ongoing:hover {
            background-color: #31b531;
            color: #fff;
        }

        .label-completed:hover {
            background-color: #2fb4dc;
            color: #fff;
        }
        .pull-left{
            float: left;
        }
        .pull-right{
            float: right;
        }
        #list_filter{
            float: right;
        }
    </style>
    {{-- start application form with wizard --}}
    @include('partials.messages')<br>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-magenta border border-magenta">
                <div class="card-header">
                    <div class="pull-left">
                        <strong><i class="fa fa-list"></i> Training Notification List</strong>
                    </div>
                    <div class="pull-right">
                        <a class="" href="{{ url('training/notification/add-notification') }}">
                            <button type="button" class="btn btn-default"><i class="fa fa-plus"></i> <b> New Notification
                                </b></button>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- /.panel-heading -->
                <div class="card-body">
                    <div class="row">
                    </div>

                    <div class="table-responsive">
                        <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Batch Name</th>
                                    <th>Session</th>
                                    <th>Notification Subject</th>
                                    <th>Participant Status</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->
                </div>
            </div>  
        </div><!-- /.col-lg-12 -->
    </div>
    

@endsection <!--content section-->
@section('footer-script')
@include('partials.datatable-js')
    <script>
        $(function() {

            $('#list').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('training/notification/get-data') }}",
                    method: 'post',
                },
                columns: [{
                        data: 'course_id',
                        name: 'course_id',
                    },
                    {
                        data: 'batch_id',
                        name: 'batch_id'
                    },
                    {
                        data: 'session_id',
                        name: 'session_id',
                    },
                    {
                        data: 'subject',
                        name: 'subject',
                    },
                    {
                        data: 'participant_status',
                        name: 'participant_status',
                    },
                ],
                "aaSorting": []
            });


        });
    </script>

@endsection <!--- footer-script--->
