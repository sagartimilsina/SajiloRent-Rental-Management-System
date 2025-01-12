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
                            {{ ucfirst($currentStatus) }} Tenant Agreements
                        </h4>
                        <div class="d-flex flex-wrap align-items-center">



                            <form action="{{ route('tenants-agreements.index') }}" method="GET"
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
                            <a href="{{ route('tenants-agreements.index') }}" class="btn btn-sm btn-info ms-2 shadow-sm">
                                <i class="bx bx-refresh me-1"></i>
                            </a>
                            <a href="{{ route('tenants-agreements.index', ['status' => 'pending']) }}"
                                class="btn btn-sm btn-primary ms-2 shadow-sm">
                                <i class="bx bx-hourglass text-white me-1"></i> Pending
                            </a>
                            <a href="{{ route('tenants-agreements.index', ['status' => 'approved']) }}"
                                class="btn btn-sm btn-success ms-2 shadow-sm">
                                <i class="bx bx-check-circle text-white me-1"></i> Approved
                            </a>
                            <a href="{{ route('tenants-agreements.index', ['status' => 'rejected']) }}"
                                class="btn btn-sm btn-danger ms-2 shadow-sm">
                                <i class="bx bx-x-circle text-white me-1"></i> Rejected
                            </a>
                            <a href="{{ route('tenants-agreements.index', ['status' => 'expired']) }}"
                                class="btn btn-sm btn-warning ms-2 shadow-sm">
                                <i class="bx bx-timer text-white me-1"></i> Expired
                            </a>
                            <a href="{{ route('tenants-agreements.trash') }}" class="btn btn-sm btn-danger ms-2 shadow-sm">
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
                                        <th>Business Name</th>
                                        <th>Full Name</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Agreement Status</th>
                                        <th>Request Status</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="mock-test-table-body">
                                    @if ($agreement_lists->count() > 0)
                                        @foreach ($agreement_lists as $item)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-wrap">
                                                    <strong>{{ $item->request->business_name ? $item->request->business_name : 'N/A' }}</strong>
                                                </td>
                                                <td class="text-wrap"><strong>{{ $item->user->name }}</strong></td>
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

                                                <td class="text-wrap"><strong>{{ $item->user->email }}</strong></td>
                                                <td><strong>{{ $item->user->phone }}</strong></td>
                                                <td>
                                                    @if ($item->agreement_status == '1')
                                                        <span class="badge bg-success">Approved</span>
                                                    @elseif($item->agreement_status == '0')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @else
                                                        <span
                                                            class="badge bg-primary">{{ ucfirst($item->agreement_status) }}</span>
                                                        <!-- For any other status -->
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->request->status == 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @elseif($item->request->status == 'approved')
                                                        <span class="badge bg-success">Approved</span>
                                                    @elseif($item->request->status == 'rejected')
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @elseif($item->request->status == 'expired')
                                                        <span class="badge bg-primary">Expired</span>
                                                    @else
                                                        <span
                                                            class="badge bg-primary">{{ ucfirst($item->request->status) }}</span>
                                                        <!-- For any other status -->
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-link p-0 text-secondary"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <form
                                                                    action="{{ route('generateAgreementPDF', $item->id) }}"
                                                                    method="GET">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $item->id }}">
                                                                    <input type="hidden" name="user_id"
                                                                        value="{{ $item->user_id }}">
                                                                    <input type="hidden" name="request_id"
                                                                        value="{{ $item->request_id }}">
                                                                    <button type="submit"
                                                                        class="dropdown-item text-primary">
                                                                        <i class="bx bx-download me-1"></i> Generate PDF
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item text-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modalToggle2{{ $item->id }}">
                                                                    <i class="bx bx-file me-1"></i> View PDF file
                                                                </button>
                                                            </li>
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
                                                                            action="{{ route('tenant-agreements.delete', $item->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
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
                                                                        Agrreement
                                                                        Details</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="mb-3 col-12">
                                                                            <label for="agreement_text"
                                                                                class="form-label">Agreement Text
                                                                            </label>
                                                                            <textarea class="form-control" id="agreement_text{{ $item->id }}" name="agreement_text" rows="2"
                                                                                placeholder="Enter Agreement Text" required>{{ $item->agreement }}</textarea>
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <form
                                                                            action="{{ route('generateAgreementPDF', $item->id) }}"
                                                                            method="GET">
                                                                            @csrf
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name="id"
                                                                                    value="{{ $item->id }}">
                                                                                <input type="hidden" name="user_id"
                                                                                    value="{{ $item->user_id }}">
                                                                                <input type="hidden" name="request_id"
                                                                                    value="{{ $item->request_id }}">


                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Generate
                                                                                    PDF</button>
                                                                            </div>
                                                                        </form>

                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="modalToggle2{{ $item->id }}"
                                                        aria-labelledby="modalToggleLabel2{{ $item->id }}"
                                                        tabindex="-1" aria-hidden="true">
                                                        <div
                                                            class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="modalToggleLabel2{{ $item->id }}">
                                                                        View Agreement PDF File
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Adjust iframe to display the PDF -->
                                                                    <iframe
                                                                        src="{{ asset('storage/' . $item->agreement_file) }}"
                                                                        frameborder="0" width="100%" height="500px">
                                                                    </iframe>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
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
                                {{ $agreement_lists->links() }}
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

            @foreach ($agreement_lists as $item)
                $('#agreement_text{{ $item->id }}')
                    .summernote({
                        placeholder: 'Enter a detailed description...',
                        tabsize: 2,
                        height: 400,
                    });
                summernote('disable');
            @endforeach

        });
    </script>
@endsection
