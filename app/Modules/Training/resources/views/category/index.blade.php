<?php
    if (!ACL::getAccsessRight('Training', '-V-')) {
        die('You have no access right! Please contact system administration for more information');
    }
?>

@extends('layouts.admin')

@section('header-resources')
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
    </style>
    @include('partials.datatable-css')
@endsection

@section('content')
    @include('partials.messages')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-magenta border border-magenta">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> Training Category List</h3>
                    <div class="card-tools">
                        <a class="" href="{{ url('/training/create-category') }}">
                            <button type="button" class="btn btn-default"><i class="fa fa-plus"></i> <b> Create Category</b></button>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Category Name (English)</th>
                                    <th>Category Name (Bangla)</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
<!--content section-->


@section('footer-script')
    @include('partials.datatable-js')
    <script>
        $(function() {

            $('#list').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('training/get-category-data') }}",
                    method: 'post',
                },
                columns: [{
                        data: 'category_name',
                        name: 'category_name',
                    },
                    {
                        data: 'category_name_bn',
                        name: 'category_name_bn'
                    },
                    {
                        data: 'status',
                        name: 'is_active',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        sortable: false
                    }
                ],
                "aaSorting": []
            });


        });
    </script>

@endsection <!--- footer-script--->
