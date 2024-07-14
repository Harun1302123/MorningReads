@extends('layouts.admin')

@section('page_heading', trans('messages.rollback'))

@section('content')
@include('partials.messages')
    @include('partials.datatable-css')
    {{-- start application form with wizard --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-magenta border border-magenta">
                <div class="card-header">
                    <div class="pull-left" style="line-height: 35px; float: left">
                        <strong><i class="fa fa-list"></i> Speaker List</strong>
                    </div>
                    <div class="pull-right" style="line-height: 35px; float: right">
                        @if(ACL::getAccsessRight('Training','A'))
                            <a class="" href="{{ url('training/speaker/create-speaker') }}">
                                <button type="button" class="btn btn-default"><i class="fa fa-plus"></i> <b> Create Speaker
                                    </b></button>
                            </a>
                        @endif
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
                                    <th> Name</th>
                                    <th> Email ID</th>
                                    <th> Phone Number</th>
                                    <th> Status</th>
                                    <th> Action</th>
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
                    url: "{{ url('training/get-speaker-data') }}",
                    method: 'post',
                    data: { status:'1' },
                },
                columns: [{
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'email',
                        name: 'eamil',
                    },
                    {
                        data: 'mobile',
                        name: 'mobile',
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false
                    }
                ],
                "aaSorting": []
            });

        });
    </script>

@endsection <!--- footer-script--->
