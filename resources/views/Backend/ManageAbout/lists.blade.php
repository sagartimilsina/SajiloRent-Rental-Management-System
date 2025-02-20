@extends('backend.layouts.main')

@section('title', 'About List')

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
                        <h5 class="mb-0 text-primary">About List</h5>
                        <div class="d-flex flex-wrap align-items-center">
                            <a href="{{ route('abouts.create') }}" class="btn btn-primary ms-2 shadow-sm">
                                <i class="bx bx-plus me-1"></i> Add
                            </a>
                        </div>


                    </div>
                    <div class="card-datatable table-responsive">
                        <table class="table border-top ">
                            <thead class="table-light ">
                                <tr>
                                    <th>SN</th>
                                    <th>Head</th>
                                    <th>Title</th>

                                    <th>Thumbnail</th>
                                    <th> Publish Status</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="mock-test-table-body">
                                @foreach ($abouts as $item)
                                    <tr class="align-middle">
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $item->head }}</strong></td>
                                        <td><strong>{{ $item->title }}</strong></td>
                                        <td>
                                            @if (!empty($item->image) && Storage::disk('public')->exists($item->image))
                                                <img src="{{ asset('storage/' . $item->image) }}"
                                                    alt="{{ $item->blog_title }}" class="img-thumbnail"
                                                    style="max-width: 100px;">
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->about_publish_status == 1)
                                                <span class="badge bg-success">Published</span>
                                            @else
                                                <span class="badge bg-danger">Unpublished</span>
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
                                                        <button type="button" class="dropdown-item text-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#ShowModal{{ $item->id }}">
                                                            <i class="bx bx-show me-1"></i> View
                                                        </button>
                                                    </li>
                                                    @if ($item->about_publish_status == 1)
                                                        <li>
                                                            <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                                                data-bs-target="#unpublishModal{{ $item->id }}">
                                                                <i class="bx bx-x-circle me-1 text-danger"></i> UnPublish
                                                            </button>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <button class="dropdown-item text-success"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#publishModal{{ $item->id }}">
                                                                <i class="bx bx-check-circle me-1 text-success"></i> Publish
                                                            </button>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('abouts.edit', ['about' => $item->id]) }}">
                                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button type="button" class="dropdown-item text-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $item->id }}">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </button>
                                                    </li>
                                                </ul>

                                                <!-- Modals for Publish/Unpublish/Delete -->

                                                <!-- Publish Modal -->
                                                <div class="modal fade" id="publishModal{{ $item->id }}" tabindex="-1"
                                                    aria-labelledby="publishModalLabel{{ $item->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="publishModalLabel{{ $item->id }}">
                                                                    Publish About</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to publish
                                                                <strong>{{ $item->head }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="{{ route('about.publish', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    @if ($item->about_publish_status === 0)
                                                                        <input type="hidden" name="about_publish_status"
                                                                            value="1">
                                                                    @endif
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit"
                                                                        class="btn btn-success">Publish</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Unpublish Modal -->
                                                <div class="modal fade" id="unpublishModal{{ $item->id }}"
                                                    tabindex="-1" aria-labelledby="unpublishModalLabel{{ $item->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="unpublishModalLabel{{ $item->id }}">
                                                                    Unpublish About</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to unpublish
                                                                <strong>{{ $item->head }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="{{ route('about.unpublish', $item->id) }}"
                                                                    method="POST">
                                                                    @method('PATCH')
                                                                    @csrf
                                                                    @if ($item->about_publish_status === 1)
                                                                        <input type="hidden" name="about_publish_status"
                                                                            value="0">
                                                                    @endif
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Unpublish</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal{{ $item->id }}"
                                                    tabindex="-1" aria-labelledby="deleteModalLabel{{ $item->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $item->id }}">
                                                                    Delete About</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete temporarily
                                                                <strong>{{ $item->head }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="{{ route('abouts.destroy', $item->id) }}"
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
                                                <div class="modal fade" id="ShowModal{{ $item->id }}" tabindex="-1"
                                                    aria-labelledby="ShowModalLabel{{ $item->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="ShowModalLabel{{ $item->id }}">
                                                                    View {{ $item->head }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="name"> Description</label>
                                                                    <textarea name="description" id="description{{ $item->id }}" cols="30" rows="10">{{ $item->description }}</textarea>

                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">

                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>


                </div>
                <!-- End of DataTable -->
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {

            @foreach ($abouts as $item)
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
