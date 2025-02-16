@extends('backend.layouts.main')

@section('title', 'Mock Tests List')

@section('content')
    <div class="container py-5">
<<<<<<< HEAD
=======
        {{-- <!-- Success Alert -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- End of Success Alert --> --}}
>>>>>>> e6e0a1f4e1304c5ead4ad7deaaf72830573ecbed

        <div class="row">
            <div class="col-12">
                <!-- DataTable with Buttons -->
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary">Testimonials List</h5>
                        <div class="d-flex flex-wrap align-items-center">
                            <!-- Search Form -->
                            <form id="search-form" class="d-flex align-items-center me-3 mb-2 mb-sm-0">
                                <div class="input-group">
                                    <input type="text" id="search-input" name="search"
                                        class="form-control form-control-md" placeholder="Search mock tests..."
                                        aria-label="Search" onkeyup="liveSearch()">
                                    <button type="submit" class="btn btn-outline-primary" id="search-button">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </div>
                            </form>
                            <!-- End Search Form -->

                            <!-- Add New Mock Test Button -->
                            <a href="{{ route('testimonials.create') }}" class="btn btn-primary ms-2 shadow-sm">
                                <i class="bx bx-plus me-1"></i> Add Testimonials
                            </a>


                            <!-- Recycle Bin Button -->
                            <a href="{{ route('testimonial.trash-view') }}" class="btn btn-danger ms-2 shadow-sm">
                                <i class="bx bx-trash me-1"></i> Recycle Bin
                            </a>
                            <!-- End Recycle Bin Button -->
                        </div>


                    </div>
                    <div class="card-datatable table-responsive">
                        <table class="table border-top ">
                            <thead class="table-light ">
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Rating</th>
                                    <th>Thumbnail</th>
                                    <th> Publish Status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody id="mock-test-table-body">
                                @foreach ($testimonials as $item)
                                    <tr class="align-middle">
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $item->name }}</strong></td>
                                        <td>{{ $item->position }}</td>
                                        <td>{{ $item->rating }}</td>

                                        <td>
                                            @if (!empty($item->image) && Storage::disk('public')->exists($item->image))
                                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                                    class="img-thumbnail" style="max-width: 100px;">
                                            @else
                                                <img src="{{ asset('sneat_backend/assets/img/noimage.png') }}"
                                                    alt="Default Thumbnail" class="img-thumbnail" style="max-width: 60px;">
                                            @endif
                                        </td>
                                        @if ($item->testimonials_publish_status == 1)
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
                                                        <button type="button" class="dropdown-item text-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#ShowModal{{ $item->id }}">
                                                            <i class="bx bx-show me-1"></i> View
                                                        </button>
                                                    </li>
                                                    @if ($item->testimonials_publish_status == 1)
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
                                                            href="{{ route('testimonials.edit', $item->id) }}">
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
                                                                    Publish Testimonial</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to publish
                                                                <strong>{{ $item->name }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('testimonial.publish', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    @if ($item->testimonials_publish_status === 0)
                                                                        <input type="hidden"
                                                                            name="testimonials_publish_status"
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
                                                    tabindex="-1"
                                                    aria-labelledby="unpublishModalLabel{{ $item->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="unpublishModalLabel{{ $item->id }}">
                                                                    Unpublish Testimonial</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to unpublish
                                                                <strong>{{ $item->name }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('testimonial.unpublish', $item->id) }}"
                                                                    method="POST">
                                                                    @method('PATCH')
                                                                    @csrf
                                                                    @if ($item->testimonials_publish_status === 1)
                                                                        <input type="hidden"
                                                                            name="testimonials_publish_status"
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
                                                                    Delete Testimonial</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete temporarily
                                                                <strong>{{ $item->name }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="{{ route('testimonial.trash', $item->id) }}"
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
                                            <div class="modal fade" id="ShowModal{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="ShowModalLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="ShowModalLabel{{ $item->id }}">
                                                                View Testimonial {{ $item->title }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="name">Testimonial Description</label>
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
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center mt-3 p-3">
                            {{ $testimonials->links() }}
                        </div>
                    </div>


                </div>
                <!-- End of DataTable -->
            </div>
        </div>
    </div>


    <!-- End of Modal to add new category -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Handle pricing dropdown change
            $('#pricing').change(function() {
                const pricing = $(this).val();
                if (pricing === 'paid') {
                    $('#pricing_amount_field').show();
                    $('#expire_date_field').show();
                } else {
                    $('#pricing_amount_field').hide();
                    $('#expire_date_field').hide();
                }
                $('#pricing_amount').prop('disabled', pricing === 'free');
            }).trigger('change'); // Trigger on page load

            // Handle form submission for adding a new category
            $('#add-category-form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission
                const formData = new FormData(this);
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle successful form submission
                        $('#addCategoryModal').modal('hide'); // Hide the modal
                        location.reload(); // Reload page to show new category
                    },
                    error: function(xhr) {
                        // Handle errors
                        handleErrors(xhr);
                    }
                });
            });

            // Function to handle AJAX errors
            function handleErrors(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    // Clear previous errors
                    $('#error-messages').show();
                    $('#error-list').empty();

                    // Display new errors
                    $.each(xhr.responseJSON.errors, function(key, errorMessages) {
                        $('#error-list').append('<li>' + errorMessages.join(', ') + '</li>');
                    });
                } else {
                    // Handle other errors
                    console.error('An error occurred:', xhr.responseText);
                }
            }

            // Handle success alert auto-hide
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(function() {
                    const alert = new bootstrap.Alert(successAlert);
                    alert.close();
                }, 5000); // 5000 milliseconds = 5 seconds
            }


        });
    </script>

    <script>
        $(document).ready(function() {

            @foreach ($testimonials as $item)
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


    <script>
        function liveSearch() {
            const input = document.getElementById('search-input').value.toLowerCase();
            const tableBody = document.getElementById('mock-test-table-body');
            const rows = tableBody.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const titleCell = rows[i].getElementsByTagName('td')[2]; // Title column const
                categoryCell = rows[i].getElementsByTagName('td')[
                    3]; // Category column if (titleCell || categoryCell) { const
                titleText = titleCell.textContent || titleCell.innerText;
                const categoryText = categoryCell.textContent ||
                    categoryCell.innerText;
                if (titleText.toLowerCase().indexOf(input) > -1 ||
                    categoryText.toLowerCase().indexOf(input) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
        }
    </script>

@endsection
