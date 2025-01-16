@extends('backend.layouts.main')

@section('title', 'Request List')

@section('content')
    <div class="container py-5">
        <!-- Success Alert -->
        {{-- @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif --}}
        <!-- End of Success Alert -->

        <div class="row">
            <div class="col-12">
                <!-- DataTable with Buttons -->
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-{{ $statusColor }}">
                            {{ ucfirst($currentStatus) }} Request List
                        </h4>
                        <div class="d-flex flex-wrap align-items-center">



                            <form action="{{ route('RequestOwnerLists.index') }}" method="GET"
                                class="d-flex align-items-center me-3 mb-2 mb-sm-0">
                                <div class="input-group">
                                    <input type="search" id="search-input" name="search"
                                        class="form-control-sm form-control " placeholder="Search by name..."
                                        aria-label="Search" value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-outline-primary" id="search-button">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </div>
                            </form>

                            <!-- End Search Form -->
                            <a href="{{ route('RequestOwnerLists.index') }}" class="btn btn-sm btn-info ms-2 shadow-sm">
                                <i class="bx bx-refresh me-1"></i>
                            </a>
                            <a href="{{ route('RequestOwnerLists.index', ['status' => 'pending']) }}"
                                class="btn btn-sm btn-primary ms-2 shadow-sm">
                                <i class="bx bx-hourglass text-white me-1"></i> Pending Request
                            </a>
                            <a href="{{ route('RequestOwnerLists.index', ['status' => 'approved']) }}"
                                class="btn btn-sm btn-success ms-2 shadow-sm">
                                <i class="bx bx-check-circle text-white me-1"></i> Approved Request
                            </a>
                            <a href="{{ route('RequestOwnerLists.index', ['status' => 'rejected']) }}"
                                class="btn btn-sm btn-danger ms-2 shadow-sm">
                                <i class="bx bx-x-circle text-white me-1"></i> Rejected Request
                            </a>
                            <a href="{{ route('RequestOwnerLists.index', ['status' => 'expired']) }}"
                                class="btn btn-sm btn-warning ms-2 shadow-sm">
                                <i class="bx bx-timer text-white me-1"></i> Expired Request
                            </a>
                            <a href="{{ route('RequestOwnerLists.trash') }}" class="btn btn-sm btn-info ms-2 shadow-sm">
                                <i class="bx bx-trash me-1"></i>
                            </a>

                        </div>


                    </div>
                    <div class="card-body">
                        <!-- Breadcrumb Navigation -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style1 py-3">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('super.admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item ">
                                    Application and Agreements
                                </li>
                                <li class="breadcrumb-item text-primary active fw-bold">
                                    Request Application
                                </li>
                                <li class="breadcrumb-item text-primary active fw-bold" aria-current="page">
                                    {{ ucfirst($currentStatus) }}
                                </li>
                            </ol>
                        </nav>
                        <div class="card-datatable table-responsive">
                            <table class="table border-top ">
                                <thead class="table-light ">
                                    <tr>
                                        <th>SN</th>
                                        <th>Full Name</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Business Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="mock-test-table-body">
                                    @if ($request_lists->count() > 0)
                                        @foreach ($request_lists as $item)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration }}</td>
                                                <td><strong>{{ $item->user->name }}</strong></td>
                                                <td class="text-capitalize">
                                                    <span
                                                        class="badge 
                                                @if ($item->user->role->role_name == 'Admin') bg-danger
                                                @elseif($item->user->role->role_name == 'User')
                                                    bg-primary
                                                @elseif($item->user->role->role_name == 'Moderator')
                                                    bg-warning
                                                @else
                                                    bg-secondary @endif">
                                                        <strong>{{ $item->user->role->role_name }}</strong>
                                                    </span>
                                                </td>

                                                <td><strong>{{ $item->user->email }}</strong></td>
                                                <td><strong>{{ $item->user->phone }}</strong></td>
                                                <td>
                                                    @if ($item->status == 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @elseif($item->status == 'approved')
                                                        <span class="badge bg-success">Approved</span>
                                                    @elseif($item->status == 'rejected')
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @elseif($item->status == 'expired')
                                                        <span class="badge bg-primary">Expired</span>
                                                    @else
                                                        <span class="badge bg-primary">{{ ucfirst($item->status) }}</span>
                                                        <!-- For any other status -->
                                                    @endif
                                                </td>
                                                <td>{{ $item->business_name }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-link p-0 text-secondary"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <button type="button" class="dropdown-item text-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modalToggle{{ $item->id }}">
                                                                    <i class="bx bx-show me-1"></i> View
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item text-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deleteModal{{ $item->id }}">
                                                                    <i class="bx bx-trash me-1"></i> Delete
                                                                </button>
                                                            </li>
                                                        </ul>
                                                        <div class="modal fade" id="deleteModal{{ $item->id }}"
                                                            tabindex="-1"
                                                            aria-labelledby="deleteModalLabel{{ $item->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="deleteModalLabel{{ $item->id }}">
                                                                            Delete Request Application</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to delete temporarily
                                                                        <strong>{{ $item->blog_title }}</strong>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form
                                                                            action="{{ route('RequestOwnerLists.destroy', $item->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Delete</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!-- Modal 1-->
                                                    <div class="modal fade" id="modalToggle{{ $item->id }}"
                                                        aria-labelledby="modalToggleLabel{{ $item->id }}"
                                                        tabindex="-1" style="display: none" aria-hidden="true">
                                                        <div
                                                            class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="modalToggleLabel{{ $item->id }}">View
                                                                        Request
                                                                        Application Details</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="accordion" id="userTypeAccordion">
                                                                        <!-- Personal Information Section -->
                                                                        <div class="accordion-item">
                                                                            <h2 class="accordion-header"
                                                                                id="headingPersonalInfo">
                                                                                <button
                                                                                    class="accordion-button text-danger"
                                                                                    type="button"
                                                                                    data-bs-toggle="collapse"
                                                                                    data-bs-target="#collapsePersonalInfo"
                                                                                    aria-expanded="true"
                                                                                    aria-controls="collapsePersonalInfo">
                                                                                    1. Personal Information
                                                                                </button>
                                                                            </h2>
                                                                            <div id="collapsePersonalInfo"
                                                                                class="accordion-collapse collapse show"
                                                                                aria-labelledby="headingPersonalInfo"
                                                                                data-bs-parent="#userTypeAccordion">
                                                                                <div class="accordion-body">
                                                                                    <div class="row">
                                                                                        <div class="mb-3 col-md-4">
                                                                                            <label for="fullName"
                                                                                                class="form-label">Full
                                                                                                Name</label>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                id="fullName"
                                                                                                name="full_name"
                                                                                                placeholder="Enter your full name"
                                                                                                value="{{ old('full_name', $item->user->name) }}"
                                                                                                @readonly(true)>
                                                                                        </div>
                                                                                        <div class="mb-3 col-md-4">
                                                                                            <label for="contactNumber"
                                                                                                class="form-label">Phone
                                                                                                Number</label>
                                                                                            <input type="tel"
                                                                                                class="form-control"
                                                                                                id="contactNumber"
                                                                                                name="phone_number"
                                                                                                placeholder="Enter your phone number"
                                                                                                value="{{ old('phone_number', $item->user->phone) }}"
                                                                                                @readonly(true)>
                                                                                        </div>
                                                                                        <div class="mb-3 col-md-4">
                                                                                            <label for="emailAddress"
                                                                                                class="form-label">Email
                                                                                                Address</label>
                                                                                            <input type="email"
                                                                                                class="form-control"
                                                                                                id="emailAddress"
                                                                                                name="email_address"
                                                                                                placeholder="Enter your email address"
                                                                                                value="{{ old('email_address', $item->user->email) }}"
                                                                                                @readonly(true)>


                                                                                        </div>
                                                                                        <div class="mb-3 col-md-4">
                                                                                            <label for="residentialAddress"
                                                                                                class="form-label">Residential
                                                                                                Address</label>
                                                                                            <p> {{ $item->residential_address }}
                                                                                            </p>
                                                                                        </div>
                                                                                        <div class="mb-3 col-md-4">
                                                                                            <label for="nationalId"
                                                                                                class="form-label">National
                                                                                                Identification
                                                                                                Number</label>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                id="nationalId"
                                                                                                name="national_id"
                                                                                                placeholder="Enter your Citizenship ID or National Identification Number"
                                                                                                value="{{ $item->national_id }}"
                                                                                                @readonly(true)>
                                                                                        </div>
                                                                                        <div class="mb-3 col-md-4">
                                                                                            <label for="govtIdProof"
                                                                                                class="form-label">Government-Issued
                                                                                                ID</label>


                                                                                            @if (isset($item->govt_id_proof) && !empty($item->govt_id_proof))
                                                                                                <div
                                                                                                    class="d-flex flex-column align-items-start">

                                                                                                    <a href="{{ asset('storage/' . $item->govt_id_proof) }}"
                                                                                                        target="_blank"
                                                                                                        title="Click to enlarge">
                                                                                                        <img src="{{ asset('storage/' . $item->govt_id_proof) }}"
                                                                                                            alt="Government-Issued ID"
                                                                                                            class="img-fluid border rounded"
                                                                                                            style="max-width: 300px; height: auto;">
                                                                                                    </a>
                                                                                                    <small
                                                                                                        class="text-muted mt-1">Click
                                                                                                        to enlarge</small>
                                                                                                </div>
                                                                                            @else
                                                                                                <p class="text-danger">No
                                                                                                    ID
                                                                                                    proof
                                                                                                    uploaded.</p>
                                                                                            @endif
                                                                                        </div>


                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Business Information Section -->
                                                                        <div class="accordion-item">
                                                                            <h2 class="accordion-header "
                                                                                id="headingBusinessInfo">
                                                                                <button
                                                                                    class="accordion-button collapsed text-danger"
                                                                                    type="button"
                                                                                    data-bs-toggle="collapse"
                                                                                    data-bs-target="#collapseBusinessInfo"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="collapseBusinessInfo">
                                                                                    2. Business Information
                                                                                </button>
                                                                            </h2>
                                                                            <div id="collapseBusinessInfo"
                                                                                class="accordion-collapse collapse"
                                                                                aria-labelledby="headingBusinessInfo"
                                                                                data-bs-parent="#userTypeAccordion">
                                                                                <div class="accordion-body">
                                                                                    <div class="row">
                                                                                        <div class="mb-3 col-md-4">
                                                                                            <label for="businessName"
                                                                                                class="form-label">Business/Company
                                                                                                Name</label>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                id="businessName"
                                                                                                name="business_name"
                                                                                                placeholder="Enter business or company name"
                                                                                                value="{{ $item->business_name }}"
                                                                                                @readonly(true)>
                                                                                        </div>
                                                                                        <div class="mb-3 col-md-4">
                                                                                            <label for="panId"
                                                                                                class="form-label">PAN
                                                                                                Registration ID</label>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                id="panId"
                                                                                                name="pan_registration_id"
                                                                                                placeholder="Enter PAN registration ID"
                                                                                                value="{{ $item->pan_registration_id }}"
                                                                                                @readonly(true)>

                                                                                        </div>
                                                                                        <div class="mb-3 col-md-4">
                                                                                            <label for="businessType"
                                                                                                class="form-label">Type of
                                                                                                Business</label>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                id="businessType"
                                                                                                name="business_type"
                                                                                                placeholder="e.g., Sole Proprietor, Partnership"
                                                                                                value="{{ $item->business_type }}"
                                                                                                @readonly(true)>
                                                                                        </div>
                                                                                        <div class="mb-3 col-md-4">
                                                                                            <label for="businessProof"
                                                                                                class="form-label">Proof of
                                                                                                Business
                                                                                                Registration</label>
                                                                                            @if (isset($item->business_proof) && !empty($item->business_proof))
                                                                                                <div
                                                                                                    class="d-flex flex-column align-items-start">

                                                                                                    <a href="{{ asset('storage/' . $item->business_proof) }}"
                                                                                                        target="_blank"
                                                                                                        title="Click to enlarge">
                                                                                                        <img src="{{ asset('storage/' . $item->business_proof) }}"
                                                                                                            alt="Business Proof"
                                                                                                            class="img-fluid border rounded"
                                                                                                            style="max-width: 300px; height: auto;">
                                                                                                    </a>
                                                                                                    <small
                                                                                                        class="text-muted mt-1">Click
                                                                                                        to enlarge</small>
                                                                                                </div>
                                                                                            @else
                                                                                                <p class="text-danger">No
                                                                                                    ID
                                                                                                    proof
                                                                                                    uploaded.</p>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    @if ($item->status !== 'pending')
                                                                        <div
                                                                            class="d-flex flex-column align-items-start gap-2">
                                                                            <div class="d-flex gap-2">
                                                                                <button class="btn btn-primary "
                                                                                    data-bs-target="#modalToggle2{{ $item->id }}"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-dismiss="modal" disabled>
                                                                                    Approve
                                                                                </button>

                                                                                <button type="button"
                                                                                    class="btn btn-danger "
                                                                                    data-bs-target="#modalToggle3{{ $item->id }}"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-dismiss="modal" disabled>
                                                                                    Reject
                                                                                </button>
                                                                            </div>

                                                                            <div class="text-danger mt-2"
                                                                                style="font-size: 0.875rem;">
                                                                                <i class="fa fa-exclamation-circle"></i>
                                                                                This record has already been updated.
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <button class="btn btn-primary"
                                                                            data-bs-target="#modalToggle2{{ $item->id }}"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-dismiss="modal">
                                                                            Approve
                                                                        </button>

                                                                        <button type="button" class="btn btn-danger"
                                                                            data-bs-target="#modalToggle3{{ $item->id }}"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-dismiss="modal">
                                                                            Reject
                                                                        </button>
                                                                    @endif
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal 2-->
                                                    <div class="modal fade" id="modalToggle2{{ $item->id }}"
                                                        aria-hidden="true"
                                                        aria-labelledby="modalToggleLabel{{ $item->id }}"2"
                                                        tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered  modal-xl">

                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="modalToggleLabel{{ $item->id }}"2">Approve
                                                                        the
                                                                        Application</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('RequestOwnerLists.approve', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="modal-body">
                                                                        <h6>Are you sure you want to approve this
                                                                            application ?
                                                                        </h6>
                                                                        <div class="row">
                                                                            <div class="mb-3 col-md-6">
                                                                                <input type="hidden" name="user_id"
                                                                                    value="{{ $item->user_id }}">
                                                                                <label for=""
                                                                                    class="form-label">Update
                                                                                    Role
                                                                                    Status</label>
                                                                                <select class="form-select form-select"
                                                                                    name="role_id" id="">
                                                                                    @foreach ($userroles as $role)
                                                                                        <option
                                                                                            value="{{ $role->id }}"
                                                                                            {{ $role->id === $item->user->role_id ? 'selected' : '' }}>
                                                                                            {{ $role->role_name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>

                                                                            </div>
                                                                            <div class="mb-3 col-md-6">

                                                                                <label for=""
                                                                                    class="form-label">Update
                                                                                    Request
                                                                                    Status</label>
                                                                                <select class="form-select form-select"
                                                                                    name="status" id="">
                                                                                    <option value="approved">Approved
                                                                                    </option>
                                                                                    <option value="rejected">Rejected
                                                                                    </option>
                                                                                    <option value="pending">Pending
                                                                                    </option>
                                                                                    <option value="expired">Expired
                                                                                    </option>
                                                                                </select>

                                                                            </div>

                                                                            <!-- Agreement Terms -->
                                                                            <h4>Agreement Terms</h4>
                                                                            <div class="mb-3 col-12">
                                                                                <label for="agreement_text"
                                                                                    class="form-label">Agreement Text
                                                                                </label>
                                                                                <textarea class="form-control" id="agreement_text{{ $item->id }}" name="agreement_text" rows="2"
                                                                                    placeholder="Enter Agreement Text" required></textarea>
                                                                            </div>
                                                                            <!-- Signatures -->

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            @if ($item->status !== 'pending')
                                                                                <button type="submit"
                                                                                    class="btn btn-primary"
                                                                                    data-bs-dismiss="modal"
                                                                                    @disabled(true)>Approve</button>
                                                                                <div class="text-danger mt-2"
                                                                                    style="font-size: 0.875rem;">
                                                                                    <i
                                                                                        class="fa fa-exclamation-circle"></i>
                                                                                    This record has already been updated.
                                                                                </div>
                                                                            @else
                                                                                <button type="submit"
                                                                                    class="btn btn-primary"
                                                                                    data-bs-dismiss="modal">Approve</button>
                                                                            @endif
                                                                            <button type="button" class="btn btn-danger"
                                                                                data-bs-target="#modalToggle{{ $item->id }}"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-dismiss="modal">
                                                                                Back
                                                                            </button>
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal 3-->
                                                    <div class="modal fade" id="modalToggle3{{ $item->id }}"
                                                        aria-hidden="true"
                                                        aria-labelledby="modalToggleLabel{{ $item->id }}"3"
                                                        tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">

                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="modalToggleLabel{{ $item->id }}"3">
                                                                        Reject the Application</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('RequestOwnerLists.reject', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="modal-body">
                                                                        <h6>Are you sure you want to reject this application
                                                                            ?
                                                                        </h6>
                                                                        <input type="hidden" name="user_id"
                                                                            id=" user_id" value="{{ $item->user_id }}">
                                                                        <div class="mb-3">

                                                                            <label for=""
                                                                                class="form-label">Update
                                                                                Request
                                                                                Status</label>
                                                                            <select class="form-select form-select-lg"
                                                                                name="status" id="">
                                                                                <option value="approved">Approved</option>
                                                                                <option value="rejected">Rejected</option>
                                                                                <option value="pending">Pending</option>
                                                                                <option value="expired">Expired</option>
                                                                            </select>

                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="exampleFormControlTextarea1"
                                                                                class="form-label">Reason</label>
                                                                            <textarea class="form-control" name = "reason" id="exampleFormControlTextarea1{{ $item->id }}"></textarea>
                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        @if ($item->status !== 'pending')
                                                                            <button type="submit" class="btn btn-primary"
                                                                                data-bs-dismiss="modal"
                                                                                @disabled(true)>Reject</button><br>
                                                                            <div class="text-danger mt-2"
                                                                                style="font-size: 0.875rem;">
                                                                                <i class="fa fa-exclamation-circle"></i>
                                                                                This record has already been updated.
                                                                            </div>
                                                                        @else
                                                                            <button type="submit" class="btn btn-primary"
                                                                                data-bs-dismiss="modal">Reject</button>
                                                                        @endif
                                                                        <button type="button" class="btn btn-danger"
                                                                            data-bs-target="#modalToggle{{ $item->id }}"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-dismiss="modal">
                                                                            Back
                                                                        </button>
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center">No data available</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3 p-3">
                                {{ $request_lists->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Modal to add new category -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {

            @foreach ($request_lists as $item)
                $('#exampleFormControlTextarea1{{ $item->id }},#agreement_text{{ $item->id }}')
                    .summernote({
                        placeholder: 'Enter a detailed description...',
                        tabsize: 2,
                        height: 400,
                    });
            @endforeach

        });
    </script>
@endsection
