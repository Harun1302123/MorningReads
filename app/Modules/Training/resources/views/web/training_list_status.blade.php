<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 px-5">
    @foreach ($course as $row)
    <div class="col mb-4">
        <div class="card course-details">
            <img src="{{ asset('/uploads/training/course/' . $row->course_thumbnail_path) }}" class="card-img-top" alt="{{ $row->course->course_title }}" onerror="this.src=`{{ asset('/assets/images/no-image.png') }}`"
                 title="{{ $row->course->course_title }}" />

            <div class="card-body">
                <h4 class="card-title">{{ $row->course->course_title }}</h4>
                      <?php
                        $enroll_deadline = strtotime($row->enroll_deadline);
                        $current_date = strtotime(date('Y-m-d'));
                        ?>
                    @if($enroll_deadline >= $current_date)
                    <span class="info-item detail">Registration Ends:
                        {{ date('d M', $enroll_deadline) }}</span>
                    @else
                        <span class="text-danger info-item detail">Registration Closed</span>
                    @endif
                <span class="info-item detail">Location : {{ $row->thana->area_nm.', '.$row->district->area_nm }}</span>
                {{-- <span class="info-item student">5,200 Student</span> --}}
            </div>
            <div class="course d-flex justify-content-between">
                <div class="course-fee">Free</div>
                <a href="{{ url('web/training-details/' . \App\Libraries\Encryption::encodeId($row->id)) }}"
                   class=" details-btn"
                   style="font-size: 13px;text-decoration: none; color: #8C0000;"> Open </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

