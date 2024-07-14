@extends('layouts.admin')

@section('content')
    <div class="card">
        @include('partials.messages')
        <div class="card-header">
            <h3 class="card-title">Contact Setting List</h3>
            <!-- /.card-tools -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0"
                            width="100%">
                            <tr style="background: #17a2b8; color: #fff">
                                <th colspan="2" class="">General Information</th>
                            </tr>
                            <tr>
                                <th>Contact Person Name</th>
                                <td>{!! $data->contact_person_one_name_en !!}</td>
                            </tr>
                            <tr>
                                <th>Contact Person Location</th>
                                <td>{!! $data->contact_person_one_location !!}</td>
                            </tr>
                            <tr>
                                <th>Contact Person Phone</th>
                                <td>{!! $data->contact_person_one_phone !!}</td>
                            </tr>
                            <tr>
                                <th>Contact Person Email</th>
                                <td>{!! $data->contact_person_one_email !!}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0"
                            width="100%">
                            <tr style="background: #17a2b8; color: #fff">
                                <th colspan="2" class="">Technical support</th>
                            </tr>
                            <tr>
                                <th>Contact Person Name</th>
                                <td>{!! $data->contact_person_two_name_en !!}</td>
                            </tr>
                            <tr>
                                <th>Contact Person Location</th>
                                <td>{!! $data->contact_person_two_location !!}</td>
                            </tr>
                            <tr>
                                <th>Contact Person Phone</th>
                                <td>{!! $data->contact_person_two_phone !!}</td>
                            </tr>
                            <tr>
                                <th>Contact Person Email</th>
                                <td>{!! $data->contact_person_two_email !!}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0"
                            width="100%">
                            <tr style="background: #17a2b8; color: #fff">
                                <th colspan="2" class="">Contact regarding software</th>
                            </tr>
                            <tr>
                                <th>Contact Person Name</th>
                                <td>{!! $data->contact_person_three_name_en !!}</td>
                            </tr>
                            <tr>
                                <th>Contact Person Designation</th>
                                <td>{!! $data->contact_person_three_designation_en !!}</td>
                            </tr>
                            <tr>
                                <th>Contact Person Phone</th>
                                <td>{!! $data->contact_person_three_phone !!}</td>
                            </tr>
                            <tr>
                                <th>Contact Person Email</th>
                                <td>{!! $data->contact_person_three_email !!}</td>
                            </tr>
                        </table>
                    </div>

                </div><!-- /.table-responsive -->
            </div>
        </div>

    </div><!-- /.panel-body -->
    <div class="card-footer">
        <div class="float-left">

        </div>
        <div class="float-right">
            <a href="{{ route('contact-setting.edit') }}" class="btn btn-primary float-right"><i
                    class="fa fa-chevron-circle-right"></i> Edit</a>
        </div>
        <div class="clearfix"></div>
    </div>
  <!-- /.panel -->
@endsection
<!--content section-->
