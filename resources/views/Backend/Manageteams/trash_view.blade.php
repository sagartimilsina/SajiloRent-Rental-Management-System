@extends('backend.layouts.main')

@section('title', 'Mock Tests List')

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
                        <h5 class="mb-0 text-primary">Teams Trash List</h5>
                        <div class="d-flex flex-wrap align-items-center">
                            <!-- Search Form -->
                            <form action ="{{ route('teams.trash-view') }}"
                                class="d-flex align-items-center me-3 mb-2 mb-sm-0">
                                <div class="input-group">
                                    <input type="search" id="search-input" name="search"
                                        class="form-control form-control-md" placeholder="Search teams ..."
                                        aria-label="Search" onkeyup="liveSearch()" value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-outline-primary" id="search-button">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </div>
                            </form>
                            <!-- End Search Form -->

                            <!-- Add New Mock Test Button -->
                            <a href="{{ route('teams.trash-view') }}" class="btn btn-info ms-2 shadow-sm">
                                <i class="bx bx-refresh me-1"></i>
                            </a>
                            <a href="{{ route('teams.index') }}" class="btn btn-primary ms-2 shadow-sm">
                                <i class="bx bx-back-arrow me-1"></i> Return To List
                            </a>
                        </div>


                    </div>
                    <div class="card-datatable table-responsive">
                        <table class="table border-top ">
                            <thead class="table-light ">
                                <tr>
                                    <th>SN</th>
                                    <th>Title</th>
                                    <th>Position</th>
                                    <th>Thumbnail</th>
                                    <th> Publish Status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody id="mock-test-table-body">
                                @if ($teams_trash->count() > 0)


                                    @foreach ($teams_trash as $item)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td><strong>{{ $item->name }}</strong></td>
                                            <td><strong>{{ $item->position }}</strong></td>
                                            <td>
                                                @if (!empty($item->image) && Storage::disk('public')->exists($item->image))
                                                    <img src="{{ asset('storage/' . $item->image) }}"
                                                        alt="{{ $item->name }}" class="img-thumbnail"
                                                        style="max-width: 100px;">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            @if ($item->team_publish_status == 1)
                                                <td><span class="badge bg-success">Published</span></td>
                                            @else
                                                <td><span class="badge bg-danger">Unpublished</span></td>
                                            @endif
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

                                                    <!-- Modals for Publish/Unpublish/Delete -->

                                                    <!-- Publish Modal -->
                                                    <div class="modal fade" id="restoreModal{{ $item->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="restoreModalLabel{{ $item->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="restoreModalLabel{{ $item->id }}">
                                                                        Restore Team</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to restore
                                                                    <strong>{{ $item->name }}</strong>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('team.restore', $item->id) }}"
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
                                                    <div class="modal fade" id="deleteModal{{ $item->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="deleteModalLabel{{ $item->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="deleteModalLabel{{ $item->id }}">
                                                                        Delete Team</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete permanently
                                                                    <strong>{{ $item->name }}</strong>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('teams.destroy', $item->id) }}"
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
                    </div>
                </div>
                <!-- End of DataTable -->
            </div>
        </div>
    </div>
@endsection
