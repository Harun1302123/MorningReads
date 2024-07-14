@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">About Us Information</h3>
            <!-- /.card-tools -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            @include('partials.messages')
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0"
                            width="100%">
                            <tr style="background: #17a2b8; color: #fff">
                                <th colspan="2" class="">About Us Information</th>
                                <th colspan="2">Action</th>
                            </tr>
                            @foreach ($about_us as $about)
                                <tr>
                                    <th>{{ $about->page_name }}</th>
                                    <td>{!! Illuminate\Support\Str::limit($about->details, 300, '.....') !!}</td>
                                    <td> <a href="{{ route('about-us.edit', ['id' => Encryption::encodeId($about->id)]) }}"
                                            class="btn btn-sm btn-outline-dark">
                                            <i class="fa fa-edit"></i>Open</a></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div><!-- /.table-responsive -->
            </div>
        </div>

    </div><!-- /.panel-body -->
    <div class="card-footer">
        <div class="float-left">

        </div>
        <div class="clearfix"></div>
    </div>
    <!-- /.panel -->
@endsection
<!--content section-->
