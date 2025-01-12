@extends('backend.layouts.main')
@section('title', 'Admin Dashboard')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4  flex-wrap">
                <div class="card">
                    {{-- <div class="card-body">
                        <a href="{{ route('.create') }}" class="btn btn-primary btn-sm btn-block"> Add Employees</a>
                        <a href="{{ route('projects.create') }}" class="btn btn-primary btn-sm btn-block"> Add Projects</a>
                        <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm btn-block"> Add Customers</a>
                        <a href="{{ route('customer-followup.create') }}" class="btn btn-primary btn-sm btn-block">Add
                            Lead</a>
                    </div> --}}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4 order-0">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-6">
                                <div class="card-body">
                                    <h5 class="card-body text-primary ">Congratulations
                                        {{ Auth::user()->name }}! 🎉</h5>

                                </div>
                            </div>
                            <div class="col-sm-6 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    {{-- <img src="{{ Auth::user()->avatar ? (filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL) ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar)) : asset('sneat_backend/assets/img/avatars/1.png') }}"
                                        height="100" alt="View Badge User"
                                        data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                        data-app-light-img="illustrations/man-with-laptop-light.png" /> --}}
                                    <img src="/sneat_backend/assets/img/illustrations/man-with-laptop-light.png"
                                        height="140" alt="View Badge User"
                                        data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4 order-0">
                    <div class="card p-2">
                        <canvas id="userEnrollmentChart" style="height: 300px;"></canvas>
                    </div>
                </div>




                <div class="col-12 col-md-12 col-lg-12 order-3 order-md-2">

                    <div class="col-lg-12 col-md-4 col-sm-6 order-1">
                        <div class="row">
                            <div class="container-fluid mt-4">
                                <div class="row">
                                    <!-- Total Users Card -->
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                        <div class="card shadow-sm border-0 rounded-3">
                                            <div class="card-body">
                                                <div class="card-title d-flex align-items-center justify-content-between">
                                                    <div class="avatar flex-shrink-0">
                                                        <i class="bx bx-user" style="font-size: 2rem; color: #4CAF50;"></i>
                                                    </div>
                                                    <h3 class="card-title mb-1 text-danger">{{ $total_users }}</h3>
                                                </div>
                                                <span class="fw-medium d-block mb-1 text-center text-primary">Total
                                                    Users</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Super Admin Users Card -->
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                        <div class="card shadow-sm border-0 rounded-3">
                                            <a href="{{ route('superadmin.users.index', ['type' => 'Super Admin']) }}">
                                                <div class="card-body">
                                                    <div
                                                        class="card-title d-flex align-items-center justify-content-between">
                                                        <div class="avatar flex-shrink-0">
                                                            <i class="bx bx-user"
                                                                style="font-size: 2rem; color: #FF5722;"></i>
                                                        </div>
                                                        <h3 class="card-title mb-1 text-danger">{{ $total_super_admins }}
                                                        </h3>
                                                    </div>
                                                    <span class="fw-medium d-block mb-1 text-center text-primary">Super
                                                        Admin Users</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Admin Users Card -->
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                        <div class="card shadow-sm border-0 rounded-3">
                                            <a href="{{ route('superadmin.users.index', ['type' => 'admin']) }}">
                                                <div class="card-body">
                                                    <div
                                                        class="card-title d-flex align-items-center justify-content-between">
                                                        <div class="avatar flex-shrink-0">
                                                            <i class="bx bx-user"
                                                                style="font-size: 2rem; color: #FF9800;"></i>
                                                        </div>
                                                        <h3 class="card-title mb-1 text-danger">{{ $total_admins }}</h3>
                                                    </div>
                                                    <span class="fw-medium d-block mb-1 text-center text-primary">Admin
                                                        Users</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Regular Users Card -->
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                        <div class="card shadow-sm border-0 rounded-3">
                                            <a href="{{ route('superadmin.users.index', ['type' => 'user']) }}">
                                                <div class="card-body">
                                                    <div
                                                        class="card-title d-flex align-items-center justify-content-between">
                                                        <div class="avatar flex-shrink-0">
                                                            <i class="bx bx-user"
                                                                style="font-size: 2rem; color: #2196F3;"></i>
                                                        </div>
                                                        <h3 class="card-title mb-1 text-danger">{{ $total_regular_users }}
                                                        </h3>
                                                    </div>
                                                    <span
                                                        class="fw-medium d-block mb-1 text-center text-primary">Users</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid mt-4">
                                <div class="row">
                                    <!-- Pending Request Applications Card -->
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                        <a href="{{ route('RequestOwnerLists.index', ['status' => 'pending']) }}">


                                            <div class="card shadow-sm border-0 rounded-3">
                                                <div class="card-body">
                                                    <div
                                                        class="card-title d-flex align-items-center justify-content-between">
                                                        <div class="avatar flex-shrink-0">
                                                            <i class="bx bx-hourglass text-primary"
                                                                style="font-size: 2rem; "></i>
                                                            <!-- Pending Icon -->
                                                        </div>


                                                        <h3 class="card-title mb-1 text-warning">
                                                            {{ $pending_request_applications }}</h3>

                                                    </div>
                                                    <span class="fw-medium d-block mb-1 text-center text-primary">Pending
                                                        Request Applications</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- Approved Request Applications Card -->
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                        <a href="{{ route('RequestOwnerLists.index', ['status' => 'approved']) }}">
                                            <div class="card shadow-sm border-0 rounded-3">
                                                <div class="card-body">
                                                    <div
                                                        class="card-title d-flex align-items-center justify-content-between">
                                                        <div class="avatar flex-shrink-0">
                                                            <i class="bx bx-check-circle"
                                                                style="font-size: 2rem; color: #4CAF50;"></i>
                                                            <!-- Approved Icon -->
                                                        </div>

                                                        <h3 class="card-title mb-1 text-success">
                                                            {{ $approved_request_applications }}</h3>

                                                    </div>
                                                    <span class="fw-medium d-block mb-1 text-center text-success">Approved
                                                        Request Applications</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- Rejected Request Applications Card -->
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                        <a href="{{ route('RequestOwnerLists.index', ['status' => 'rejected']) }}">
                                            <div class="card shadow-sm border-0 rounded-3">
                                                <div class="card-body">
                                                    <div
                                                        class="card-title d-flex align-items-center justify-content-between">
                                                        <div class="avatar flex-shrink-0">
                                                            <i class="bx bx-x-circle"
                                                                style="font-size: 2rem; color: #F44336;"></i>
                                                            <!-- Rejected Icon -->
                                                        </div>



                                                        <h3 class="card-title mb-1 text-danger">
                                                            {{ $rejected_request_applications }}</h3>

                                                    </div>
                                                    <span class="fw-medium d-block mb-1 text-center text-danger">Rejected
                                                        Request Applications</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <!-- Expired Request Applications Card -->
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                        <a href="{{ route('RequestOwnerLists.index', ['status' => 'expired']) }}">
                                            <div class="card shadow-sm border-0 rounded-3">
                                                <div class="card-body">
                                                    <div
                                                        class="card-title d-flex align-items-center justify-content-between">
                                                        <div class="avatar flex-shrink-0">
                                                            <i class="bx bx-timer"
                                                                style="font-size: 2rem; color: #FFC107;"></i>
                                                            <!-- Expired Icon -->
                                                        </div>
                                                        <h3 class="card-title mb-1 text-warning">
                                                            {{ $expired_request_applications }}</h3>
                                                    </div>
                                                    <span class="fw-medium d-block mb-1 text-center "
                                                        style=" color: #FFC107;">Expired Request Applications</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                {{-- <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <!-- Using a user icon from Boxicons to represent employees -->
                                                <i class="bx bx-user" style="font-size: 2rem; color: #6b4caf;"></i>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn p-0" type="button" id="cardOpt6"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                                    <a class="dropdown-item" href="{{ route('employees.index') }}">View
                                                        More</a>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="fw-medium d-block mb-1">Total Employees</span>
                                        <!-- Displaying total employees count dynamically -->
                                        <h3 class="card-title text-nowrap mb-1 text-danger">{{ $employeeCount }}</h3>
                                    </div>
                                </div> --}}

                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                {{-- <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <!-- Using a user icon from Boxicons to represent customers -->
                                                <i class="bx bx-user-circle" style="font-size: 2rem; color: #4caf50;"></i>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn p-0" type="button" id="cardOpt7"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt7">
                                                    <a class="dropdown-item" href="{{ route('customers.index') }}">View
                                                        More</a>

                                                </div>
                                            </div>
                                        </div>
                                        <span class="fw-medium d-block mb-1 ">Total Customers</span>
                                        <!-- Displaying total customers count dynamically -->
                                        <h3 class="card-title text-nowrap mb-1 text-danger">{{ $customerCount }}</h3>

                                    </div>
                                </div> --}}
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                {{-- <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <!-- Using a user icon from Boxicons to represent customers -->
                                                <i class="bx bx-user-circle" style="font-size: 2rem; color: #4caf50;"></i>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn p-0" type="button" id="cardOpt7"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt7">
                                                    <a class="dropdown-item" href="{{ route('customers.index') }}">View
                                                        More</a>

                                                </div>
                                            </div>
                                        </div>
                                        <span class="fw-medium d-block mb-1 ">Total Lead</span>
                                        <!-- Displaying total customers count dynamically -->
                                        <h3 class="card-title text-nowrap mb-1 text-danger">{{ $leadCount }}</h3>

                                    </div>
                                </div> --}}
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                <div class="card">
                                    {{-- <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <!-- Using a calendar icon from Boxicons to represent follow-ups -->
                                                <i class="bx bx-calendar" style="font-size: 2rem; color: #4cacaf;"></i>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn p-0" type="button" id="cardOpt4"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>

                                                </div>
                                            </div>
                                        </div>
                                        <span class="d-block mb-1 fw-bold text-nowrap">Today's Due Follow Ups</span>
                                        <!-- Dummy value for the number of due follow-ups -->
                                        <h3 class="card-title text-nowrap mb-1 text-danger">{{ $todayfollowups->count() }}
                                        </h3>
                                        <!-- Displaying the latest date -->
                                        <small class="text-muted d-block mb-1">Date: <span
                                                class="fw-bold">{{ now()->format('F j, Y g:i A') }}</span></small>

                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                <div class="card">
                                    {{-- <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <!-- Using a calendar icon from Boxicons to represent follow-ups -->
                                                <i class="bx bx-calendar" style="font-size: 2rem; color: #4cacaf;"></i>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn p-0" type="button" id="cardOpt4"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="d-block mb-1 fw-bold">Weekly FollowUps</span>
                                        <!-- Dummy value for the number of weekly follow-ups -->
                                        <h3 class="card-title text-nowrap mb-1 text-danger">
                                            {{ $weeklyfollowups->count() }}
                                        </h3>
                                        <small class="text-muted d-block mb-1">Date: <span
                                                class="fw-bold">{{ now()->format('F j, Y ') }} </span>
                                            to
                                            <span
                                                class="fw-bold">{{ now()->addDays(6)->format('F j, Y ') }}</span></small>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                <div class="card">
                                    {{-- <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <!-- Using a calendar icon from Boxicons to represent follow-ups -->
                                                <i class="bx bx-calendar" style="font-size: 2rem; color: #4cacaf;"></i>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn p-0" type="button" id="cardOpt4"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>

                                                </div>
                                            </div>
                                        </div>
                                        <span class="d-block mb-1 fw-bold">Missing FollowUps</span>
                                        <!-- Dummy value for the number of weekly follow-ups -->
                                        <h3 class="card-title text-nowrap mb-1 text-danger">
                                            {{ $missingfollowups->count() }}
                                        </h3>

                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                <div class="card">
                                    {{-- <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <!-- Using a calendar icon from Boxicons to represent follow-ups -->
                                                <i class="bx bx-calendar" style="font-size: 2rem; color: #4cacaf;"></i>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn p-0" type="button" id="cardOpt4"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                                    <a class="dropdown-item"
                                                        href="{{ route('project-error-assign.index') }}">View More</a>

                                                </div>
                                            </div>
                                        </div>
                                        <span class="d-block mb-1 fw-bold">Raise Ticket Support</span>
                                        <!-- Dummy value for the number of weekly follow-ups -->
                                        <h3 class="card-title text-nowrap mb-1 text-danger">{{ $total_raise_ticket }}</h3>

                                    </div> --}}
                                </div>
                            </div>
                            {{-- @foreach ($status_counts as $status_name => $ticket_count)
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                    <div class="card">
                                        {{-- <div class="card-body">
                                            <div class="card-title d-flex align-items-start justify-content-between">
                                                <div class="avatar flex-shrink-0">
                                                    <!-- Using a calendar icon from Boxicons to represent the status -->
                                                    <i class="bx bx-calendar"
                                                        style="font-size: 2rem; color: #4cacaf;"></i>
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn p-0" type="button" id="cardOpt4"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="cardOpt4">
                                                        <a class="dropdown-item"
                                                            href="{{ route('project-error-assign.index', ['status' => $status_name]) }}">View
                                                            More</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Status Title -->
                                            <span class="d-block mb-1 fw-bold">{{ $status_name }} Tickets</span>
                                            <!-- Dynamic value for the number of tickets -->
                                            <h3 class="card-title text-nowrap mb-1 text-danger">{{ $ticket_count }}</h3>
                                        </div> 
                                    </div>
                                </div>
                            @endforeach --}}

                        </div>
                    </div>
                </div>

            </div>
            <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="statusModalLabel">Change Task Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="statusForm">
                                <input type="hidden" id="taskId" name="task_id">
                                <div class="form-group">
                                    <label for="taskStatus">Select Status</label>
                                    <select class="form-control" id="taskStatus" name="status">
                                        <option value="0">Pending</option>
                                        <option value="1">In Progress</option>
                                        <option value="2">Completed</option>
                                        <option value="3">Cancelled</option>
                                        <option value="4">Closed</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="saveStatusBtn">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


            {{-- <script>
                $(document).ready(function() {
                    function showToast(type, message, title = 'Notification') {
                        const toast = $('#toastMessage'); // Get the toast container
                        toast.removeClass('bg-success bg-danger').addClass(`bg-${type}`);
                        $('#toastBody').text(message);
                        toast.fadeIn().show();
                        setTimeout(function() {
                            toast.fadeOut();
                        }, 5000);
                    }

                    function showSuccessToast(message) {
                        showToast('success', message, 'Success');
                    }

                    function showErrorToast(message) {
                        showToast('danger', message, 'Error');
                    }

                    // Open status modal and populate data
                    $(document).on('click', '.toggle-status', function() {
                        let taskId = $(this).data('id');
                        let currentStatus = $(this).data('status');

                        $('#taskId').val(taskId);
                        $('#taskStatus').val(currentStatus);
                    });

                    // Handle Save Status button click
                    $('#saveStatusBtn').on('click', function() {
                        let taskId = $('#taskId').val();
                        let status = $('#taskStatus').val();

                        $.ajax({
                            url: "{{ route('followup.updateStatus', ':taskId') }}".replace(':taskId',
                                taskId),
                            type: 'PATCH',
                            data: {
                                id: taskId,
                                status: status,
                                _token: '{{ csrf_token() }}'
                            },
                            beforeSend: function() {
                                $('#saveStatusBtn').prop('disabled', true);
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    // Find the table row corresponding to the task ID
                                    let row = $('tr').find(`.toggle-status[data-id='${taskId}']`)
                                        .closest('tr');

                                    // Update the status badge
                                    row.find('span.badge').attr('class', `badge ${response.badgeClass}`)
                                        .text(response.statusText);

                                    // Update the dropdown item for status
                                    let dropdownItem = row.find(`.toggle-status[data-id='${taskId}']`);
                                    dropdownItem.data('status', status);
                                    dropdownItem.removeClass().addClass(
                                        `dropdown-item toggle-status ${response.buttonClass}`);

                                    // Hide the modal
                                    $('#statusModal').modal('hide');

                                    // Show success toast
                                    showSuccessToast(response.message);
                                } else {
                                    showErrorToast('Failed to update status');
                                }
                            },
                            error: function() {
                                showErrorToast('Error updating status');
                            },
                            complete: function() {
                                $('#saveStatusBtn').prop('disabled', false);
                            }
                        });
                    });
                });
            </script> --}}

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Get data passed from the controller
                const labels = @json($labels); // Daily labels (e.g., "2025-01-01")
                const data = @json($data); // Counts of registrations per day

                // Create the chart
                const ctx = document.getElementById('userEnrollmentChart').getContext('2d');
                const userEnrollmentChart = new Chart(ctx, {
                    type: 'line', // Line chart type
                    data: {
                        labels: labels, // X-axis labels (daily data)
                        datasets: [{
                            label: 'User Enrollments (Daily)', // Chart label
                            data: data, // Y-axis data (counts)
                            borderColor: 'rgba(75, 192, 192, 1)', // Line color
                            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Fill color
                            borderWidth: 5,
                            tension: 0.3, // Smoothing for the line
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true, // Show legend
                            },
                            tooltip: {
                                enabled: true, // Enable tooltips
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Day'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Number of Users'
                                },
                                beginAtZero: true // Start Y-axis at zero
                            }
                        }
                    }
                });
            </script>

        @endsection
