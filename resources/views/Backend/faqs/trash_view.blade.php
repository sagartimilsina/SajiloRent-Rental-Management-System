@extends('backend.layouts.main')

@section('title', 'FAQ Trash List')

@section('content')
    <div class="container py-5">
        <!-- Success Alert -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- End of Success Alert -->

        <div class="row">
            <div class="col-12">
                <!-- Trash Table -->
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary">FAQ Trash List</h5>
                        <div class="d-flex align-items-center">
                            <!-- Search Form -->
                            <form id="search-form" class="d-flex align-items-center me-3 mb-2 mb-sm-0" method="GET"
                                action="">
                                <div class="input-group">
                                    <input type="text" id="search-input" name="search"
                                        class="form-control form-control-md" placeholder="Search FAQs..."
                                        aria-label="Search" onkeyup="liveSearch()">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </div>
                            </form>
                            <!-- Add New Mock Test Button -->
                            <a href="{{ route('faqs.trash-view') }}" class="btn btn-info ms-2 shadow-sm">
                                <i class="bx bx-refresh me-1"></i>
                            </a>
                            <!-- Return to FAQ List Button -->
                            <a href="{{ route('faqs.index') }}" class="btn btn-primary ms-2 shadow-sm">
                                <i class="bx bx-back-arrow me-1"></i> Return To List
                            </a>
                        </div>
                    </div>

                    <div class="card-datatable table-responsive">
                        <table class="table border-top">
                            <thead class="table-light">
                                <tr>
                                    <th>SN</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th>Publish Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="mock-test-table-body">
                                @if ($faqs_trash->count() > 0)
                                @foreach ($faqs_trash as $item)
                                    <tr class="align-middle">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->question }}</td>
                                        <td>{!! Str::limit(strip_tags($item->answer), 50, '...') !!}</td>
                                        @if ($item->faq_publish_status == 1)
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
                                                    <!-- Restore FAQ -->
                                                    <li>
                                                        <button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#restoreModal{{ $item->id }}">
                                                            <i class="bx bx-undo text-primary me-1"></i> Restore
                                                        </button>
                                                    </li>
                                                    <!-- Delete FAQ -->
                                                    <li>
                                                        <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $item->id }}">
                                                            <i class="bx bx-trash me-1"></i> Delete Permanently
                                                        </button>
                                                    </li>
                                                </ul>
                                                <!-- Modals for Publish/Unpublish/Delete -->

                                                <!-- Publish Modal -->
                                                <div class="modal fade" id="restoreModal{{ $item->id }}" tabindex="-1"
                                                    aria-labelledby="restoreModalLabel{{ $item->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="restoreModalLabel{{ $item->id }}">
                                                                    Restore Testimonial</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to restore
                                                                <strong>{{ $item->name }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="{{ route('faq.restore', $item->id) }}"
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
                                                    aria-labelledby="deleteModalLabel{{ $item->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $item->id }}">
                                                                    Delete Testimonial</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete permanently
                                                                <strong>{{ $item->name }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="{{ route('faqs.destroy', $item->id) }}"
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

                        <!-- Pagination -->
                        {{ $faqs_trash->links() }}
                    </div>
                </div>
                <!-- End of Trash Table -->
            </div>
        </div>
    </div>
    <!-- End of Modal to add new category -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {

            @foreach ($faqs_trash as $item)
                $('#description{{ $item->id }}').summernote({
                    placeholder: 'Enter a detailed description...',
                    tabsize: 2,
                    height: 200,
                    // toolbar: false,  // Disable toolbar
                    disableDragAndDrop: true, // Disable drag and drop
                    callbacks: {
                        onInit: function() {
                            // Make the content non-editable
                            $(this).summernote('disable');
                        }
                    }
                });
            @endforeach

        });
    </script>


@endsection
