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
                        <h4 class="mb-0 text-primary">Request List Trashed List</h4>
                        <div class="d-flex flex-wrap align-items-center">


                            <!-- Search Form -->
                            {{-- <form action ="{{ route('RequestOwnerLists.index') }}"
                                class="d-flex align-items-center me-3 mb-2 mb-sm-0">
                                <div class="input-group">
                                    <input type="search" id="search-input" name="search"
                                        class="form-control form-control-md" placeholder="Search ..."
                                        aria-label="Search" onkeyup="liveSearch()">
                                    <button type="submit" class="btn btn-outline-primary" id="search-button">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </div>
                            </form> --}}
                            <form action="{{ route('RequestOwnerLists.trash') }}" method="GET"
                                class="d-flex align-items-center me-3 mb-2 mb-sm-0">
                                <div class="input-group">
                                    <input type="search" id="search-input" name="search"
                                        class="form-control form-control-md" placeholder="Search by name..."
                                        aria-label="Search" value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-outline-primary" id="search-button">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </div>
                            </form>

                            <a href="{{ route('RequestOwnerLists.index') }}" class="btn btn-sm btn-info ms-2 shadow-sm">
                                <i class="bx bx-arrow-back me-1"></i>
                            </a>

                        </div>


                    </div>
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
                                @if ($request_owner_lists->count() > 0)
                                    @foreach ($request_owner_lists as $item)
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
                                                            <button class="dropdown-item text-danger" data-bs-toggle="modal"
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

                                        <!-- Modals for Publish/Unpublish/Delete -->

                                        <!-- Publish Modal -->
                                        <div class="modal fade" id="restoreModal{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="restoreModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="restoreModalLabel{{ $item->id }}">
                                                            Restore Request Application</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to restore?

                                                    </div>
                                                    <div class="modal-footer">
                                                        <form
                                                            action="{{ route('request_owner_lists.restore', $item->id) }}"
                                                            method="GET">
                                                            @csrf

                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-success">Restore</button>
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
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">
                                                            Delete Request Application</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete permanently?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('request_owner_lists.delete', $item->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
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
                            {{ $request_owner_lists->links() }}
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

            @foreach ($request_owner_lists as $item)
                $('#exampleFormControlTextarea1{{ $item->id }}').summernote({
                    placeholder: 'Enter a detailed description...',
                    tabsize: 2,
                    height: 200,
                });
            @endforeach

        });
    </script>
@endsection
