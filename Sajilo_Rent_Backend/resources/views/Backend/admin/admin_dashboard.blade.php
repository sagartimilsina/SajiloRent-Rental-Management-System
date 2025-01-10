@extends('backend.layouts.main')
@section('title', 'Admin Dashboard')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4  flex-wrap">
                <div class="card">
                    {{-- <div class="card-body">
                        <a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm btn-block"> Add Employees</a>
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
                                    <h5 class="card-title text-primary ">Congratulations
                                        {{ Auth::user()->name }}! 🎉</h5>
                                    <p class="mb-4">
                                        You have done <span class="fw-bold">72%</span> more sales today. Check your new
                                        badge in
                                        your profile.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
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
                        <div class="renewal-projects-section">
                            <span class="d-block mb-1 fw-bold">Renewal Projects</span>
                            <div class="alert alert-warning" role="alert">
                                <i class="bx bx-bell"></i> Reminder: Some projects are up for renewal soon. Please take
                                action!
                            </div>
                            <div class="table-responsive text-nowrap" style="max-height: 150px; overflow-y: auto;">
                                <table class="table">
                                    <ul class="list-group">
                                        {{-- @foreach ($renewalprojects as $item)
                                            <a href="{{ route('projects.show', $item->id) }}">
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ $item->project_name }}
                                                    @if (isset($item->days_remaining))
                                                        {{-- Badge color logic based on remaining days 
                                                        @if ($item->days_remaining > 10)
                                                            <span class="badge bg-success"> {{ $item->days_remaining }} days
                                                                remaining</span>
                                                        @elseif ($item->days_remaining <= 10 && $item->days_remaining > 0)
                                                            <span class="badge bg-warning"> {{ $item->days_remaining }} days
                                                                remaining</span>
                                                        @else
                                                            <span class="badge bg-danger"> {{ $item->days_remaining }} days
                                                                remaining</span>
                                                        @endif
                                                    @elseif (isset($item->days_overdue))
                                                        {{-- Overdue case, always show in danger 
                                                        <span class="badge bg-danger"> {{ $item->days_overdue }} days
                                                            overdue</span>
                                                    @endif
                                                </li>
                                            </a>
                                        @endforeach --}}
                                    </ul>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-12 order-3 order-md-2">
                    <div class="row">
                        <div class="col-12 mb-4">
                            {{-- <div class="card">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-header">Today Follow Ups</h5>
                                    <a class="btn btn-primary btn-sm m-2"
                                        href="{{ route('customer.followup_type', ['type' => 'today', 'date' => \Carbon\Carbon::now()->toDateString()]) }}"
                                        role="button">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="table-responsive text-nowrap" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                                <th>Lead Name</th>
                                                <th>Follow Up Title</th>
                                                <th>Follow Up Time</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <style>
                                            .table tbody tr td {

                                                font-size: 12.5px;
                                            }

                                            .table tbody tr td p {
                                                text-align: left;
                                            }
                                        </style>
                                        <tbody class="table-border-bottom-0">
                                            @if (@$todayfollowups->count() > 0)
                                                @foreach (@$todayfollowups as $item)
                                                    <tr>
                                                        <td class="text-wrap">{{ $item->customer->customer_name }}</td>
                                                        <td>
                                                            <p class="text-justify text-wrap">{{ $item->task_title }}</p>
                                                            <p class="text-justify text-wrap">
                                                                {!! Illuminate\Support\Str::limit(strip_tags($item->remarks), 150, '...') !!}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($item->followup_time)->format('h:i A') }}
                                                        </td>
                                                        <td>{{ $item->customer->customer_phone_1 }}</td>

                                                        <td>
                                                            @switch($item->status)
                                                                @case(0)
                                                                    <span class="badge bg-label-danger">Pending</span>
                                                                @break

                                                                @case(1)
                                                                    <span class="badge bg-label-primary">In Progress</span>
                                                                @break

                                                                @case(2)
                                                                    <span class="badge bg-label-success">Completed</span>
                                                                @break

                                                                @case(3)
                                                                    <span class="badge bg-label-danger">Cancelled</span>
                                                                @break

                                                                @case(4)
                                                                    <span class="badge bg-label-dark">Closed</span>
                                                                @break

                                                                @default
                                                                    <span class="badge bg-label-secondary">Unknown</span>
                                                            @endswitch
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a href="#"
                                                                        class="dropdown-item toggle-status {{ getStatusClass($item->status) }}"
                                                                        data-id="{{ $item->id }}"
                                                                        data-status="{{ $item->status }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#statusModal">
                                                                        Change Status

                                                                    </a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('customer.followupaddmoredetails', ['id' => $item->customer_id]) }}"><i
                                                                            class="fa fa-add me-1  "></i>Add Follow Up</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('customer-followup-task.view', ['task' => $item->id]) }}"><i
                                                                            class="fa fa-eye me-1 "></i>View</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('customer-followup.show', ['customer_followup' => $item->customer_id]) }}"><i
                                                                            class="fa fa-list-alt me-1 "></i>View Lists</a>
                                                                    @if (@$item->followup->status == 1)
                                                                        <button class="dropdown-item" type="button"
                                                                            data-id="{{ $item->followup->id }}"
                                                                            data-name="{{ $item->followup->name }}"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#closeModal{{ $item->followup->id }}">
                                                                            <i class="fas fa-times me-1 text-danger"></i>
                                                                            Closed
                                                                            Lead
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="closeModal{{ $item->followup->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="closeModalLabel{{ $item->followup->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="closeModalLabel{{ $item->followup->id }}">
                                                                        Close
                                                                        Lead</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form
                                                                        action="{{ route('customer-followup.status', $item->followup->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <input type="hidden" name="status"
                                                                            value="{{ $item->followup->status }}">
                                                                        <div class="mb-3">
                                                                            <label for="remarks{{ $item->followup->id }}"
                                                                                class="form-label">Remarks</label>
                                                                            <textarea name="last_remarks" id="remarks" class="form-control summernote" rows="4"
                                                                                placeholder="Write remarks here..." required></textarea>

                                                                        </div>
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="button"
                                                                                class="btn btn-secondary me-2"
                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit"
                                                                                class="btn btn-success">Close
                                                                                Lead</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">No Follow Ups Today</td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-12 mb-4">
                            {{-- <div class="card">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-header">Weekly Follow Ups</h5>
                                    @php
                                        $startDate = \Carbon\Carbon::tomorrow(); // Start date: Tomorrow
                                        $endDate = $startDate->copy()->addDays(7); // End date: 7 days after tomorrow
                                        $dateRange = $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d'); // Format as a range string

                                    @endphp

                                    <a class="btn btn-primary btn-sm m-2"
                                        href="{{ route('customer.followup_type', ['type' => 'weekly', 'date' => $dateRange]) }}"
                                        role="button">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>

                                </div>

                                <div class="table-responsive text-nowrap" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Lead Name</th>
                                                <th class="text-wrap">Follow Up Title</th>
                                                <th class="text-wrap">Follow Up Date</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @if (@$weeklyfollowups->count() > 0)
                                                @foreach ($weeklyfollowups as $item)
                                                    <tr>
                                                        <td class="text-wrap">{{ $item->customer->customer_name }}</td>
                                                        <td>
                                                            <p class="text-justify text-wrap">
                                                                {{ $item->task_title ?? 'N/A' }}
                                                            </p>
                                                            <p class="text-justify text-wrap">
                                                                {!! Illuminate\Support\Str::limit(strip_tags($item->remarks), 150, '...') !!}
                                                            </p>

                                                        </td>
                                                        <td>
                                                            <p class="text-wrap">
                                                                {{ \Carbon\Carbon::parse($item->followup_date)->format('d-m-Y') }}
                                                            </p>
                                                            <p>{{ \Carbon\Carbon::parse($item->followup_time)->format('h:i A') }}
                                                            </p>
                                                        </td>
                                                        <td>{{ $item->customer->customer_phone_1 }}</td>
                                                        <td>
                                                            @switch($item->status)
                                                                @case(0)
                                                                    <span class="badge bg-label-secondary">Pending</span>
                                                                @break

                                                                @case(1)
                                                                    <span class="badge bg-label-primary">In Progress</span>
                                                                @break

                                                                @case(2)
                                                                    <span class="badge bg-label-success">Completed</span>
                                                                @break

                                                                @case(3)
                                                                    <span class="badge bg-label-danger">Cancelled</span>
                                                                @break

                                                                @case(4)
                                                                    <span class="badge bg-label-dark">Closed</span>
                                                                @break

                                                                @default
                                                                    <span class="badge bg-label-secondary">Unknown</span>
                                                            @endswitch
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a href="#"
                                                                        class="dropdown-item toggle-status {{ getStatusClass($item->status) }}"
                                                                        data-id="{{ $item->id }}"
                                                                        data-status="{{ $item->status }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#statusModal">
                                                                        Change Status

                                                                    </a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('customer.followupaddmoredetails', ['id' => $item->customer_id]) }}"><i
                                                                            class="fa fa-add me-1  "></i>Add Follow Up</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('customer-followup-task.view', ['task' => $item->id]) }}"><i
                                                                            class="fa fa-eye me-1 "></i>View</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('customer-followup.show', ['customer_followup' => $item->customer_id]) }}"><i
                                                                            class="fa fa-list me-1 "></i>View Lists</a>
                                                                    @if (@$item->followup->status == 1)
                                                                        <button class="dropdown-item" type="button"
                                                                            data-id="{{ $item->followup->id }}"
                                                                            data-name="{{ $item->followup->title }}"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#closeModal{{ $item->followup->id }}">
                                                                            <i class="fas fa-times me-1 text-danger"></i>
                                                                            Closed Lead
                                                                        </button>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="closeModal{{ $item->followup->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="closeModalLabel{{ $item->followup->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="closeModalLabel{{ $item->followup->id }}">
                                                                        Close
                                                                        Lead</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form
                                                                        action="{{ route('customer-followup.status', $item->followup->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <input type="hidden" name="status"
                                                                            value="{{ $item->followup->status }}">
                                                                        <div class="mb-3">
                                                                            <label for="remarks{{ $item->followup->id }}"
                                                                                class="form-label">Remarks</label>
                                                                            <textarea name="last_remarks" id="remarks" class="form-control summernote" rows="4"
                                                                                placeholder="Write remarks here..." required></textarea>

                                                                        </div>
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="button"
                                                                                class="btn btn-secondary me-2"
                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit"
                                                                                class="btn btn-success">Close
                                                                                Lead</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">No Follow Ups weekly</td>
                                                </tr>

                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-12 mb-4">
                            {{-- <div class="card">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-header">Missing Follow Ups</h5>
                                    @php
                                        $todayDate = now()->format('Y-m-d'); // Get today's date in 'YYYY-MM-DD'
                                    @endphp

                                    <a class="btn btn-primary btn-sm m-2"
                                        href="{{ route('customer.followup_type', ['type' => 'missing', 'date' => '<' . $todayDate]) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </div>

                                <div class="table-responsive text-nowrap" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Lead Name</th>
                                                <th>Follow Up Title</th>
                                                <th class="text-wrap">Follow Up Date</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody class="table-border-bottom-0">
                                            @if ($missingfollowups->count() > 0)
                                                @foreach ($missingfollowups as $item)
                                                    <tr>
                                                        <td>{{ $item->customer->customer_name }}</td>
                                                        <td>
                                                            <p class="text-wrap text-justify">{{ $item->task_title }}</p>
                                                            <p class="text-justify text-wrap">
                                                                {!! Illuminate\Support\Str::limit(strip_tags($item->remarks), 150, '...') !!}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p>{{ \Carbon\Carbon::parse($item->followup_date)->format('d-m-Y') }}
                                                            </p>
                                                            <p>{{ \Carbon\Carbon::parse($item->followup_time)->format('h:i A') }}
                                                            </p>
                                                        </td>
                                                        <td>{{ $item->customer->customer_phone_1 }}</td>
                                                        <td>
                                                            @switch($item->status)
                                                                @case(0)
                                                                    <span class="badge bg-label-secondary">Pending</span>
                                                                @break

                                                                @case(1)
                                                                    <span class="badge bg-label-primary">In Progress</span>
                                                                @break

                                                                @case(2)
                                                                    <span class="badge bg-label-success">Completed</span>
                                                                @break

                                                                @case(3)
                                                                    <span class="badge bg-label-danger">Cancelled</span>
                                                                @break

                                                                @case(4)
                                                                    <span class="badge bg-label-dark">Closed</span>
                                                                @break

                                                                @default
                                                                    <span class="badge bg-label-secondary">Unknown</span>
                                                            @endswitch
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>

                                                                <div class="dropdown-menu">
                                                                    <a href="#"
                                                                        class="dropdown-item toggle-status {{ getStatusClass($item->status) }}"
                                                                        data-id="{{ $item->id }}"
                                                                        data-status="{{ $item->status }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#statusModal">
                                                                        Change Status

                                                                    </a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('customer.followupaddmoredetails', ['id' => $item->customer_id]) }}"><i
                                                                            class="fa fa-add me-1"></i>Add Follow Up</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('customer-followup-task.view', ['task' => $item->id]) }}"><i
                                                                            class="fa fa-eye me-1 "></i>View</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('customer-followup.show', ['customer_followup' => $item->customer_id]) }}"><i
                                                                            class="fa fa-list me-1 "></i>View Lists</a>
                                                                    @if (@$item->followup->status == 1)
                                                                        <button class="dropdown-item" type="button"
                                                                            data-id="{{ $item->followup->id }}"
                                                                            data-name="{{ $item->followup->title }}"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#closeModal{{ $item->followup->id }}">
                                                                            <i class="fas fa-times me-1 text-danger"></i>
                                                                            Closed Lead
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="closeModal{{ $item->followup->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="closeModalLabel{{ $item->followup->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="closeModalLabel{{ $item->followup->id }}">
                                                                        Close
                                                                        Lead</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form
                                                                        action="{{ route('customer-followup.status', $item->followup->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <input type="hidden" name="status"
                                                                            value="{{ $item->followup->status }}">
                                                                        <div class="mb-3">
                                                                            <label for="remarks{{ $item->followup->id }}"
                                                                                class="form-label">Remarks</label>
                                                                            <textarea name="last_remarks" id="remarks" class="form-control summernote" rows="4"
                                                                                placeholder="Write remarks here..." required></textarea>

                                                                        </div>
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="button"
                                                                                class="btn btn-secondary me-2"
                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit"
                                                                                class="btn btn-success">Close
                                                                                Lead</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">No Missing Follow Ups</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div> --}}
                        </div>
                    </div>


                    <div class="col-lg-12 col-md-4 col-sm-6 order-1">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                {{-- <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <!-- Updated icon path to represent projects -->
                                                <i class="bx bx-box" style="font-size: 2rem; color: #4CAF50;"></i>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn p-0" type="button" id="cardOpt3"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                                    <a class="dropdown-item" href="{{ route('projects.index') }}">View
                                                        More</a>

                                                </div>
                                            </div>
                                        </div>
                                        <span class="fw-medium d-block mb-1">Total Projects</span>
                                        <!-- Fetching total projects count dynamically -->
                                        <h3 class="card-title mb-1 text-danger">{{ $projectCount }}</h3>
                                    </div>

                                </div> --}}
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

        @endsection
