<?php

if (!empty($process_info)) {
    $accessMode = ACL::getAccsessRight($process_info->acl_name);
    if (!ACL::isAllowed($accessMode, '-V-')) {
        die('no access right!');
    }
}

$moduleName = Request::segment(1);
$user_type = CommonFunction::getUserType();
$desk_id_array = explode(',', \Session::get('user_desk_ids'));
$delegatedUserDeskOfficeIds = CommonFunction::getDelegatedUserDeskOfficeIds();

?>
@extends('layouts.admin')

@section('header-resources')
    <style>
        .unreadMessage td {
            font-weight: bold;
        }
    </style>
    @include('partials.datatable-css')
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" />
@endsection

@section('content')

    @include('partials.messages')

    @if (empty($delegated_desk))
        <div class="modal fade" id="ProjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" id="frmAddProject"></div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-magenta border border-magenta" style="">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5><i class="fa fa-list"></i> <b>{!! trans('ProcessPath::messages.application_list') !!}
                                    <span class="list_name"></span>
                                    @if (isset($process_info->name))
                                        for
                                        ({{ $process_info->name }})
                                </b>
                                @endif
                            </h5>
                        </div>
                        <div class="col-lg-6">
                            @if (!empty($process_info))
                                @if (ACL::getAccsessRight($process_info->acl_name, '-A-'))
                                    <a href="{{ URL::to('client/process/' . $process_info->form_url . '/add/' . \App\Libraries\Encryption::encodeId($process_info->id)) }}"
                                        class="float-right">
                                        {!! Form::button('<i class="fa fa-plus"></i> <b>New Application</b>', [
                                            'type' => 'button',
                                            'class' => 'btn btn-default',
                                        ]) !!}
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="clearfix">
                        <div class="" id="statuswiseAppsDiv" style="display: none">


                        </div>

                    </div>


                    <div class="nav-tabs-custom" style="margin-top: 15px;padding: 0px 5px;">
                        <nav class="navbar navbar-expand-mdjustify-content-center">

                            <ul class="nav nav-tabs">
                                @if ($user_type != '1x101' && $user_type != '5x505' && $user_type != '6x606')
                                    <li id="tab1" class="nav-item ">
                                        <a data-toggle="tab" href="#list_desk" class="mydesk nav-link active"
                                            aria-expanded="true">
                                            <b>{!! trans('ProcessPath::messages.my_desk') !!}</b>
                                        </a>
                                    </li>
                                    @if (!empty($delegatedUserDeskOfficeIds))
                                        <li id="tab2" class="nav-item" style="width: 180px;"
                                            title="Delegate tab application is pendding">
                                            <img class="img-responsive float-left" src="/assets/images/bell_animated.gif"
                                                alt="Your Alt Tag is Here" title="Delegation tab application is pendding"
                                                style="width: 40px;">
                                        @else
                                        <li id="tab2" class="">
                                    @endif
                                    <a data-toggle="tab" href="#list_delg_desk" aria-expanded="false"
                                        class=" nav-link delgDesk">
                                        <b>{!! trans('ProcessPath::messages.delegation_desk') !!}</b>
                                    </a>
                                    </li>
                                @else
                                    <li id="tab1" class="nav-item active">
                                        <a data-toggle="tab" href="#list_desk" class="mydesk nav-link active"
                                            aria-expanded="true">
                                            <b>{!! trans('ProcessPath::messages.list') !!}</b>
                                        </a>
                                    </li>
                                @endif

                                <li id="tab4" class="nav-item">
                                    <a data-toggle="tab" href="#favoriteList" class="favorite_list nav-link"
                                        aria-expanded="true">
                                        <b>{!! trans('ProcessPath::messages.favourite') !!}</b>
                                    </a>
                                </li>

                                <li id="tab3" class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#list_search" id="search_by_keyword"
                                        aria-expanded="false">
                                        <b>{!! trans('ProcessPath::messages.search') !!}</b>
                                    </a>
                                </li>
                            </ul>

                            <ul class="navbar-nav ml-auto">
                                <div class="row">
                                    <li class="process_type_tab nav-item" id="processDropdown">
                                        {!! Form::select('ProcessType', ['0' => 'সকল তথ্য'] + $ProcessType, $process_type_id, [
                                            'class' => 'form-control ProcessType',
                                        ]) !!}
                                    </li>
                                </div>
                            </ul>
                        </nav>
                        <div id="reyad" class="tab-content">
                            <div id="list_desk" class="tab-pane active" style="margin-top: 20px">
                                <table id="table_desk" class="table table-striped table-bordered display"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 15%;">{!! trans('ProcessPath::messages.tracking_no') !!}</th>
                                            <th>{!! trans('ProcessPath::messages.current_desk') !!}</th>
                                            <th>{!! trans('ProcessPath::messages.process_type') !!}</th>
                                            <th style="width: 35%">{!! trans('ProcessPath::messages.reference_data') !!}</th>
                                            <th>{!! trans('ProcessPath::messages.status_') !!}</th>
                                            <th>{!! trans('ProcessPath::messages.modified') !!}</th>
                                            <th>{!! trans('ProcessPath::messages.action') !!}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            <div id="list_search" class="tab-pane" style="margin-top: 20px">
                                @include('ProcessPath::search')
                            </div>
                            <div id="list_delg_desk" class="tab-pane" style="margin-top: 20px">
                                <div class="table-responsive">
                                    <table id="table_delg_desk" class="table table-striped table-bordered display"
                                        style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 15%;">{!! trans('ProcessPath::messages.tracking_no') !!}</th>
                                                <th>{!! trans('ProcessPath::messages.current_desk') !!}</th>
                                                <th>{!! trans('ProcessPath::messages.process_type') !!}</th>
                                                <th style="width: 35%">{!! trans('ProcessPath::messages.reference_data') !!}</th>
                                                <th>{!! trans('ProcessPath::messages.status_') !!}</th>
                                                <th>{!! trans('ProcessPath::messages.modified') !!}</th>
                                                <th>{!! trans('ProcessPath::messages.action') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="favoriteList" class="tab-pane" style="margin-top: 20px">
                                <div class="table-responsive">
                                    <table id="favorite_list" class="table table-striped table-bordered display"
                                        style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 15%;">{!! trans('ProcessPath::messages.tracking_no') !!}</th>
                                                <th>{!! trans('ProcessPath::messages.current_desk') !!}</th>
                                                <th>{!! trans('ProcessPath::messages.process_type') !!}</th>
                                                <th style="width: 35%">{!! trans('ProcessPath::messages.reference_data') !!}</th>
                                                <th>{!! trans('ProcessPath::messages.status_') !!}</th>
                                                <th>{!! trans('ProcessPath::messages.modified') !!}</th>
                                                <th>{!! trans('ProcessPath::messages.action') !!}</th>
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
            </div>
        </div>
    </div>

@endsection
@section('footer-script')
    @include('partials.datatable-js')
    <script src="{{ asset('assets/scripts/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />

    <script language="javascript">
        $('.mydesk').click(function() {
            $('#processDropdown').show();
        });

        $('.favorite_list').click(function() {
            $('#processDropdown').hide();
        });

        $('.search_by_keyword').click(function() {
            $('#processDropdown').hide();
        });

        $(function() {
            // Global search or dashboard search option
            @if (isset($search_by_keyword) && !empty($search_by_keyword))
                $('#search_by_keyword').trigger('click');
                return false;
            @endif

            var table = [];

            /**
             * set selected ProcessType in session
             * load data by ProcessType, on change ProcessType select box
             * @type {jQuery}
             */
            $('.ProcessType').change(function() {
                var process_type_id = $(this).val();
                sessionStorage.setItem("process_type_id", process_type_id);
            });
            $('.ProcessType').trigger('change');

            /**
             * table desk script
             * @type {jQuery}
             */
            table_desk = $('#table_desk').DataTable({
                iDisplayLength: '{{ $number_of_rows }}',
                processing: true,
                serverSide: true,
                searching: true,
                responsive: true,
                "bDestroy": true,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: '{{ route('process.getList', ['-1000', 'my-desk']) }}',
                    method: 'get',
                    data: function(d) {
                        d.process_type_id = parseInt(sessionStorage.getItem("process_type_id"));
                    }
                },
                columns: [{
                        data: 'tracking_no',
                        name: 'tracking_no',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'user_desk.desk_name',
                        name: 'user_desk.desk_name',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'process_name',
                        name: 'process_name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'json_object',
                        name: 'json_object',
                        orderable: false,
                    },
                    {
                        data: 'process_status.status_name',
                        name: 'process_status.status_name',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                "aaSorting": []
            });


            /**
             * on click Delegation Desk load table with delegated application list
             * @type {jQuery}
             */
            var deleg_list_flag = 0;
            $('.delgDesk').click(function() {
                /**
                 * delegated application list table script
                 * @type {jQuery}
                 */
                if (deleg_list_flag == 0) {
                    deleg_list_flag = 1;
                    $('#table_delg_desk').DataTable({
                        iDisplayLength: '{{ $number_of_rows }}',
                        processing: true,
                        serverSide: true,
                        searching: true,
                        responsive: true,
                        ajax: {
                            url: '{{ route('process.getList', ['-1000', 'my-delg-desk']) }}',
                            method: 'get',
                            data: function(d) {
                                d._token = $('input[name="_token"]').val();
                                d.process_type_id = parseInt(sessionStorage.getItem(
                                    "process_type_id"));
                            }
                        },
                        columns: [{
                                data: 'tracking_no',
                                name: 'tracking_no',
                                orderable: false,
                                searchable: true
                            },
                            {
                                data: 'user_desk.desk_name',
                                name: 'user_desk.desk_name',
                                orderable: false,
                                searchable: true
                            },
                            {
                                data: 'process_name',
                                name: 'process_name',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'json_object',
                                name: 'json_object',
                                orderable: false,
                            },
                            {
                                data: 'process_status.status_name',
                                name: 'process_status.status_name',
                                orderable: false,
                                searchable: true
                            },
                            {
                                data: 'updated_at',
                                name: 'updated_at',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                        "aaSorting": []
                    });
                }

            });


            /**
             * on click favourite Desk load table with favourite application list
             * @type {jQuery}
             */
            var fav_list_flag = 0;
            $('.favorite_list').click(function() {
                /**
                 * delegated application list table script
                 * @type {jQuery}
                 */
                if (fav_list_flag == 0) {
                    fav_list_flag = 1;
                    $('#favorite_list').DataTable({
                        iDisplayLength: '{{ $number_of_rows }}',
                        processing: true,
                        serverSide: true,
                        searching: true,
                        responsive: true,
                        ajax: {
                            url: '{{ route('process.getList', ['-1000', 'favorite_list']) }}',
                            method: 'get',
                            data: function(d) {
                                d._token = $('input[name="_token"]').val();
                                d.process_type_id = parseInt(sessionStorage.getItem(
                                    "process_type_id"));
                            }
                        },
                        columns: [{
                                data: 'tracking_no',
                                name: 'tracking_no',
                                orderable: false,
                                searchable: true
                            },
                            {
                                data: 'user_desk.desk_name',
                                name: 'user_desk.desk_name',
                                orderable: false,
                                searchable: true
                            },
                            {
                                data: 'process_name',
                                name: 'process_name',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'json_object',
                                name: 'json_object',
                                orderable: false,
                            },
                            {
                                data: 'process_status.status_name',
                                name: 'process_status.status_name',
                                orderable: false,
                                searchable: true
                            },
                            {
                                data: 'updated_at',
                                name: 'updated_at',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                        "aaSorting": []
                    });
                }
            });
        });

        $('body').on('click', '.favorite_process', function() {

            var process_list_id = $(this).attr('id');
            $(this).css({
                "color": "#f0ad4e"
            }).removeClass('fa-star-o favorite_process').addClass('fa fa-star remove_favorite_process');
            $(this).attr("title", "Added to your favorite list");
            var _token = $('input[name="_token"]').val();
            $.ajax({
                type: "POST",
                url: "<?php echo url('/process/favorite-data-store'); ?>",
                data: {
                    _token: _token,
                    process_list_id: process_list_id
                },
                success: function(response) {
                    if (response.responseCode == 1) {
                    }
                }
            });
        });

        $('body').on('click', '.remove_favorite_process', function() {

            var process_list_id = $(this).attr('id');
            $(this).css({
                "color": ""
            }).removeClass('fa fa-star remove_favorite_process').addClass('fa fa-star-o favorite_process');
            $(this).attr("title", "Add to your favorite list");


            var _token = $('input[name="_token"]').val();
            $.ajax({
                type: "POST",
                url: "<?php echo url('/process/favorite-data-remove'); ?>",
                data: {
                    _token: _token,
                    process_list_id: process_list_id
                },
                success: function(response) {
                    btn.html(btn_content);
                    if (response.responseCode == 1) {
                    }
                }
            });
        });

        @if (\App\Libraries\CommonFunction::getUserType() == '4x404')
            //current used the code for update batch
            $('body').on('click', '.is_delegation', function() {
                var is_blank_page = $(this).attr('target');
                var _token = $('input[name="_token"]').val();
                var current_process_id = $(this).parent().parent().find('.batchInputStatus').val();

                $.ajax({
                    type: "get",
                    url: "<?php echo url('/'); ?>/process/batch-process-set",
                    async: false,
                    data: {
                        _token: _token,
                        is_delegation: true,
                        current_process_id: current_process_id,
                    },
                    success: function(response) {

                        if (response.responseType == 'single') {
                            // window.location.href = response.url;
                            if (is_blank_page === undefined) {
                                window.location.href = response.url;
                            }
                            window.open(response.url, '_blank');
                        }
                        if (response.responseType == false) {
                            toastr.error('did not found any data for search list!');
                        }
                    }

                });
                return false;
            });

            $('body').on('click', '.common_batch_update', function() {
                var current_process_id = $(this).parent().find('.batchInput').val();

                process_id_array = [];
                $('.batchInput').each(function(i, obj) {
                    process_id_array.push(this.value);
                });
                process_id_array = process_id_array.filter(onlyUnique);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    type: "get",
                    url: "<?php echo url('/'); ?>/process/batch-process-set",
                    async: false,
                    data: {
                        _token: _token,
                        process_id_array: process_id_array,
                        current_process_id: current_process_id,
                    },
                    success: function(response) {
                        if (response.responseType == 'single') {
                            // return false
                            window.location.href = response.url;
                        }
                        if (response.responseType == false) {
                            toastr.error('did not found any data for search list!');
                        }
                    }

                });
                return false;
            });

            function onlyUnique(value, index, self) {
                return self.indexOf(value) === index;
            }
        @endif
        $('body').on('change', '.ProcessType', function() {
            var current_process_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                type: "post",
                url: "<?php echo url('/'); ?>/process/get-servicewise-count",
                async: false,
                data: {
                    _token: _token,
                    current_process_id: current_process_id,
                },
                success: function(response) {
                    if (response) {
                        $("#statuswiseAppsDiv").html(response).show();
                    }
                }

            });

        });
    </script>
    @yield('footer-script2')
@endsection
