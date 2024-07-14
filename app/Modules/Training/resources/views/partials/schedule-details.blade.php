<div class="card card-magenta border border-magenta">
    <div class="card-header">
        <div class="pull-left" style="padding-top: 7px">
            <b> <i class="fa fa-list"></i> Training Schedule </b>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- /.panel-heading -->
    <div class="card-body">
        <div class="col-lg-12">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Schedule Info</legend>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 row">
                                        <label for="reg_type_id" class="col-md-2 col-xs-12">Training Title</label>
                                        <div class="col-md-10 col-xs-12">
                                            <span>: {{ $course->course->course_title }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 row">
                                        <label for="expected_starting_date" class="col-md-4 col-xs-12">Course Start and
                                            End
                                            time</label>
                                        <div class="col-md-7 col-xs-12">
                                            :<span class="input_ban"> {{ \Carbon\Carbon::parse($course->course_duration_start)->format('d F Y') }} -
                                                {{ \Carbon\Carbon::parse($course->course_duration_end)->format('d F Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 row">
                                        <label for="speaker_mobile" class="col-md-4 col-xs-12">Total Hour</label>
                                        <div class="col-md-7 col-xs-12">
                                            :<span class="input_ban"> {{ $course->total_hours }} hr </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 row">
                                        <label for="speaker_mobile" class="col-md-4 col-xs-12">Total class</label>
                                        <div class="col-md-7 col-xs-12">
                                            :<span class="input_ban"> {{ $course->no_of_class }} </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 row">
                                        <label for="enrolment_deadline" class="col-md-4 col-xs-12">Enrollment
                                            Deadline</label>
                                        <div class="col-md-7 col-xs-12">
                                            :<span class="input_ban"> {{ \Carbon\Carbon::parse($course->enroll_deadline)->format('d F Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 row">
                                        <label for="course_location" class="col-md-4 col-xs-12">District</label>
                                        <div class="col-md-7 col-xs-12">
                                            <span>: {{ $course->district->area_nm }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 row">
                                        <label for="course_location" class="col-md-4 col-xs-12">Thana/Upazilla</label>
                                        <div class="col-md-7 col-xs-12">
                                            <span>: {{ $course->thana->area_nm }}</span>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 row">
                                        <label for="course_location" class="col-md-4 col-xs-12">Course Venue</label>
                                        <div class="col-md-7 col-xs-12">
                                            <span>: {{ $course->venue }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 row">
                                        <label for="course_location" class="col-md-4 col-xs-12">Number of Batches</label>
                                        <div class="col-md-7 col-xs-12">
                                            <span>: {{ $course->no_of_batch }}</span>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 row">
                                        <label for="course_location" class="col-md-4 col-xs-12">Expectinf Starting Date</label>
                                        <div class="col-md-7 col-xs-12">
                                            <span>: {{ \Carbon\Carbon::parse($course->expect_start)->format('d F Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </fieldset>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Schedule Session info</legend>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" style="margin-bottom: 0px;">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <table id="courseDetailTable" class="table table-bordered dt-responsive"
                                            cellspacing="0" width="100%" style="margin-bottom: 0px;">
                                            <thead style="background-color: #3379b77e">
                                                <tr>
                                                    <th class="text-center">Session Time</th>
                                                    <th class="text-center width-20">Day</th>
                                                    <th class="text-center" width="15%">Total Applicant </th>
                                                    <th class="text-center" width="15%">Speaker Name </th>
                                                    <th class="text-center">Batch No</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($course->scheduleSessions as $session)
                                                    <tr>
                                                        <td>
                                                            <p class="text-center">{{\Carbon\Carbon::createFromFormat('H:i:s', $session->session_start_time)->format('h:i A').' to '.\Carbon\Carbon::createFromFormat('H:i:s', $session->session_end_time)->format('h:i A') }}</p>
                                                        </td>
                                                        <td style="width: 20%">
                                                            <p class="text-center">{{ $session->session_days }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-center">
                                                                {{ $session->seat_capacity == 0 ? '-' : $session->seat_capacity }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="text-center">
                                                                {{ $session->speaker->speaker_name}}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="text-center">{{ $session->session_name }}</p>
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
                </div>
            </fieldset>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">General Info</legend>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <label for="qualifications" class="col-md-3 col-xs-3">Necessary Qualification:
                                        </label>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="col-md-12">
                                            <span> {!! $course->necessary_qualification_experience !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <label for="qualifications" class="col-md-3 col-xs-3">Course Goal:
                                        </label>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="col-md-12">
                                            <span> {!! $course->objectives !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <label for="qualifications" class="col-md-3 col-xs-3">Course Outline: </label>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="col-md-12">
                                            <span> {!! $course->course_contents !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <label for="qualifications" class="col-md-3 col-xs-3">Course Description:
                                        </label>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="col-md-12">
                                            <span> {!! $course->course->course_description !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <label for="reg_type_id" class="col-md-5 col-xs-5">Course Thumbnail: </label>

                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <img src="{{ asset('/uploads/training/thumbnails/'.$course->course_thumbnail_path) }}"
                                            class="img-responsive img-thumbnail course_image_thumbnail"
                                            id="course_thumbnail_preview"
                                            onerror="this.src=`{{ asset('/assets/images/photo_default.png') }}`">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div><!-- /.box -->
    <div class="card-footer">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <a class="pull-left" href="{{ url('/training/schedule/list') }}">

                        <button type="button" class="btn btn-sm btn-default"><i class="fa fa-times"
                                style="margin-right: 5px;"></i>Close</button>
                    </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                @if ($course->is_publish == 0 && Auth::user()->desk_training_id == 2 && ACL::getAccsessRight('Training-Desk', '-DE-'))
                    <div class="col-md-6">
                        <a class="pull-right"
                            href="{{ url('/training/schedule-update/' . \App\Libraries\Encryption::encodeId($course->id)) }}">
                            <button type="button" class="btn btn-sm btn-success"><i
                                    class="fas fa-check"></i>Approve</button>
                        </a>
                    </div>
                @endif

            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
