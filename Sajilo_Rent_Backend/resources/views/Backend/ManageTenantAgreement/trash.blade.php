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
                            {{ ucfirst($currentStatus) }} Tenant Agreements Trashed List
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
                            <a href="{{ route('tenants-agreements.trash') }}" class="btn btn-sm btn-info ms-2 shadow-sm">
                                <i class="bx bx-refresh me-1"></i>
                            </a>
                            <a href="{{ route('tenants-agreements.trash', ['status' => 'pending']) }}"
                                class="btn btn-sm btn-primary ms-2 shadow-sm">
                                <i class="bx bx-hourglass text-white me-1"></i> Pending
                            </a>
                            <a href="{{ route('tenants-agreements.trash', ['status' => 'approved']) }}"
                                class="btn btn-sm btn-success ms-2 shadow-sm">
                                <i class="bx bx-check-circle text-white me-1"></i> Approved
                            </a>
                            <a href="{{ route('tenants-agreements.trash', ['status' => 'rejected']) }}"
                                class="btn btn-sm btn-danger ms-2 shadow-sm">
                                <i class="bx bx-x-circle text-white me-1"></i> Rejected
                            </a>
                            <a href="{{ route('tenants-agreements.trash', ['status' => 'expired']) }}"
                                class="btn btn-sm btn-warning ms-2 shadow-sm">
                                <i class="bx bx-timer text-white me-1"></i> Expired
                            </a>
                            <a href="{{ route('tenants-agreements.index') }}" class="btn btn-sm btn-danger ms-2 shadow-sm">
                                <i class="bx bx-arrow-back me-1"></i>
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
                                <li class="breadcrumb-item text-primary  fw-bold">
                                    Tenant Agreements
                                </li>
                                <li class="breadcrumb-item text-primary active fw-bold">
                                    Trashed
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
                                                                <button class="dropdown-item text-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#restoreModal{{ $item->id }}">
                                                                    <i class="bx bx-undo me-1 text-primary"></i> Restore
                                                                </button>
                                                            </li>


                                                            <li>
                                                                <button class="dropdown-item text-success"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deleteModal{{ $item->id }}">
                                                                    <i class="bx bx-trash me-1 text-danger"></i> Delete
                                                                </button>
                                                            </li>
                                                        </ul>

                                                    </div>

                                                </td>
                                            </tr>
                                            <div class="modal fade" id="restoreModal{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="restoreModalLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="restoreModalLabel{{ $item->id }}">
                                                                Restore Request Application</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to restore?

                                                        </div>
                                                        <div class="modal-footer">
                                                            <form
                                                                action="{{ route('tenant_agreement.restore', $item->id) }}"
                                                                method="GET">
                                                                @csrf

                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-success">Restore</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="deleteModalLabel{{ $item->id }}">
                                                                Delete Request Application</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete permanently?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form
                                                                action="{{ route('tenants-agreements.destroy', $item->id) }}"
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
