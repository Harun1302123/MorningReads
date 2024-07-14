@if (checkUserPermissionTraining())
    <li class="nav-item {{ Request::is('training/*') ? 'menu-is-opening menu-open' : '' }}">
        <a href="javascript:void(0)"
            class="nav-link  {{ Request::is('training/*') ? 'active' : '' }}">
            <i class="nav-icon far fa-plus-square"></i>
            <p>Training</p>
            <i class="fas fa-angle-left right"></i>
        </a>

        <ul class="nav nav-treeview">
            {{-- super admin --}}
            @if ($type[0] == '1')
                <li class="nav-item">
                    <a href="{{ url('training/speaker/list') }}"
                        class="nav-link {{ Request::is('training/speaker/list') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Speaker</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ url('/training/category-list') }}"
                        class="nav-link {{ Request::is('training/category-list') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Category</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('training/organization/all-list') || Request::is('organization/*') ? 'active' : '' }}" href="{{ url("/training/organization/all-list") }}">
                        <i class="nav-icon fa fa-file  fa-fw"></i>
                        <p>Organization</p>
                    </a>
                </li>
            
            @endif

            @if (checkUserTrainingDesk())
                @if (checkTrainingDirector())
                <li class="nav-item">
                    <a href="{{ url('/training/course-list') }}"
                        class="nav-link {{ Request::is('training/course-list') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Course</p>
                    </a>
                </li>
                @endif
            
                <li class="nav-item">
                    <a href="{{ url('training/schedule/list') }}"
                        class="nav-link {{ Request::is('training/schedule/list') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Training Schedule</p>
                    </a>
                </li>

                @if (checkTrainingCoordinator())
                <li class="nav-item">
                    <a href="{{ url('training/attendance/create') }}"
                        class="nav-link {{ Request::is('training/attendance/create') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Attendance</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('training/evaluation/create') }}"
                        class="nav-link {{ Request::is('training/evaluation/create') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Marking</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('training/notification/add-notification') }}"
                        class="nav-link {{ Request::is('training/notification/add-notification') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Notifications</p>
                    </a>
                </li>
                @endif
            @endif

            @if (checkTrainee())
            <li class="nav-item">
                <a href="{{ url('/training/upcoming-course') }}"
                    class="nav-link {{ Request::is('training/upcoming-course') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Upcoming Course</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/training/purchase-course') }}"
                    class="nav-link {{ Request::is('training/purchase-course') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Purchsed Course</p>
                </a>
            </li>
            @endif

        </ul>
    </li>
@endif
