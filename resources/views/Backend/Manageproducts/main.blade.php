@extends('backend.layouts.main')

@section('title', 'Product List')

@section('content')
    <div class="container py-5">


        <div class="row">
            <div class="col-12">
                <!-- DataTable with Buttons -->
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary">
                            Product List
                        </h4>
                        <div class="d-flex flex-wrap align-items-center">
                            <form action="{{ route('products.index') }}" method="GET"
                                class="d-flex align-items-center me-3 mb-2 mb-sm-0">
                                <div class="input-group">
                                    <input type="search" id="search-input" name="search"
                                        class="form-control-sm form-control " placeholder="Search by products name..."
                                        aria-label="Search" value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-outline-primary" id="search-button">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </div>
                            </form>

                            <!-- End Search Form -->
                            <a href="{{ route('products.index') }}" class="btn btn-sm btn-info ms-2 shadow-sm">
                                <i class="bx bx-refresh me-1"></i>
                            </a>
                            <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary ms-2 shadow-sm">
                                <i class="bx bx-plus me-1"></i>
                            </a>


                            <a href="{{ route('products.trash-view') }}" class="btn btn-sm btn-danger ms-2 shadow-sm">
                                <i class="bx bx-trash me-1"></i>
                            </a>

                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Breadcrumb Navigation -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style1 py-3">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item ">
                                    Property/Product Management
                                </li>
                                <li class="breadcrumb-item text-primary active fw-bold">
                                    Product List
                                </li>
                            </ol>
                        </nav>
                        <div class="card-datatable table-responsive">
                            <table class="table border-top ">
                                <thead class="table-light ">
                                    <tr>
                                        <th>SN</th>
                                        <th>Category Name</th>
                                        <th>Sub Category Name</th>
                                        <th>Product Title</th>
                                        @if (Auth::user()->role->role_name == 'Super Admin')
                                            <th>Created By</th>
                                        @endif
                                        <th>Product Image</th>
                                        <th>Publish Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="mock-test-table-body">
                                    @if ($products->count() > 0)
                                        @foreach ($products as $item)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration }}</td>
                                                <td><strong>{{ $item->category->category_name }}</strong></td>
                                                <td><strong>{{ @$item->subcategory->sub_category_name }}</strong></td>
                                                <td>{{ $item->property_name }}</td>

                                                <td><img src="{{ asset('storage/' . $item->property_image) }}"
                                                        alt="Icon" style="width: 100px; height: 100px; "></td>

                                                @if (Auth::user()->role->role_name == 'Super Admin')
                                                    <td><strong>{{ @$item->user->name }}</strong></td>
                                                @endif


                                                @if ($item->property_publish_status == 1)
                                                    <td><span class="badge bg-success">Published</span></td>
                                                @else
                                                    <td><span class="badge bg-danger">UnPublished</span></td>
                                                @endif
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-link p-0 text-secondary"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="{{ route('products.show', $item->id) }}"
                                                                    class="dropdown-item text-info">
                                                                    <i class="bx bx-show me-1"></i> View
                                                                </a>
                                                            </li>
                                                            @if (Auth::user()->role->role_name != 'Super Admin' && Auth::user()->role->role_name != '')
                                                                <li>
                                                                    <a href="{{ route('products.edit', $item->id) }}"
                                                                        class="dropdown-item text-primary">
                                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('products.images', $item->id) }}"
                                                                        class="dropdown-item text-warning">
                                                                        <i class="bx bx-plus me-1 text-warning"></i>
                                                                        Add or View Images
                                                                    </a>
                                                                </li>

                                                                @if ($item->property_publish_status == 1)
                                                                    <li>
                                                                        <button class="dropdown-item text-danger"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#unpublishModal{{ $item->id }}">
                                                                            <i class="bx bx-x-circle me-1 text-danger"></i>
                                                                            UnPublish
                                                                        </button>
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        <button class="dropdown-item text-success"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#publishModal{{ $item->id }}">
                                                                            <i
                                                                                class="bx bx-check-circle me-1 text-success"></i>
                                                                            Publish
                                                                        </button>
                                                                    </li>
                                                                @endif

                                                                <li>
                                                                    <button type="button" class="dropdown-item text-danger"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#deleteModal{{ $item->id }}">
                                                                        <i class="bx bx-trash me-1"></i> Delete
                                                                    </button>
                                                                </li>
                                                            @endif


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
                                                                            Delete </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to delete temporarily
                                                                        <strong>{{ $item->property_name }}</strong>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form
                                                                            action="{{ route('product.trash', $item->id) }}"
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
                                                <!-- Publish Modal -->
                                                <div class="modal fade" id="publishModal{{ $item->id }}"
                                                    tabindex="-1" aria-labelledby="publishModalLabel{{ $item->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="publishModalLabel{{ $item->id }}">
                                                                    Publish Property</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to publish
                                                                <strong>{{ $item->property_name }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="{{ route('product.publish', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    @if ($item->property_publish_status === 0)
                                                                        <input type="hidden" name="publish_status"
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
                                                                    Unpublish Property</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to unpublish
                                                                <strong>{{ $item->property_name }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="{{ route('product.unpublish', $item->id) }}"
                                                                    method="POST">
                                                                    @method('PATCH')
                                                                    @csrf
                                                                    @if ($item->property_publish_status === 1)
                                                                        <input type="hidden" name="publish_status"
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
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalToggle" tabindex="-1" aria-labelledby="modalToggleLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalToggleLabel">Add Product Categories</h5>
                    {{-- <button type="button" class="btn-close" aria-label="Close"></button> --}}
                </div>
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="category_name" class="form-label">Category Name</label>
                                <input type="text" class="form-control" name="category_name" id="category_name"
                                    placeholder="Enter category name">
                            </div>
                            <div class="col-md-6">
                                <label for="category_icon" class="form-label">Category Icon</label>
                                <input type="file" class="form-control" name="icon" id="category_icon"
                                    accept="image/*">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm" id="addCategory">Add Category</button>
                        <hr>
                        <h5>Added Categories</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th>Category Icon</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="categoryTable">
                                <!-- Added categories will be displayed here -->
                            </tbody>
                        </table>
                        <input type="hidden" name="categories" id="categoriesInput">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Save Categories</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalToggle');
            const bootstrapModal = bootstrap.Modal.getOrCreateInstance(modal);

            let allowClose = false; // Flag to control modal closing

            // Intercept modal close event
            modal.addEventListener('hide.bs.modal', function(event) {
                if (!allowClose) {
                    const triggeredBy = event.relatedTarget;

                    // Check if the event was triggered by clicking outside the modal or pressing ESC
                    if (!triggeredBy || triggeredBy.id !== 'saveCategories') {
                        event.preventDefault(); // Prevent the modal from closing

                        if (confirm('Are you sure you want to close without saving?')) {
                            allowClose = true; // Allow closing the modal
                            bootstrapModal.hide(); // Programmatically hide the modal
                        }
                    }
                } else {
                    allowClose = false; // Reset the flag for future modal interactions
                }
            });
        });

        let categories = [];

        // Handle Add Category
        document.getElementById('addCategory').addEventListener('click', function() {
            const nameInput = document.getElementById('category_name');
            const iconInput = document.getElementById('category_icon');

            if (!nameInput.value) {
                alert('Category name is required!');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                // Add category to the array
                categories.push({
                    name: nameInput.value,
                    icon: e.target.result
                });

                // Render categories in the table
                renderCategories();

                // Reset input fields
                nameInput.value = '';
                iconInput.value = '';
            };

            reader.readAsDataURL(iconInput.files[0]);
        });

        // Handle Remove Category
        function removeCategory(index) {
            categories.splice(index, 1);
            renderCategories();
        }

        // Render Categories in Table
        function renderCategories() {
            const tableBody = document.getElementById('categoryTable');
            tableBody.innerHTML = '';

            categories.forEach((category, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
            <td>${category.name}</td>
            <td><img src="${category.icon}" alt="Icon" style="width: 50px; height: 50px; object-fit: cover;"></td>
            <td><button class="btn btn-danger btn-sm" onclick="removeCategory(${index})">Remove</button></td>
        `;
                tableBody.appendChild(row);
            });

            // Update the hidden input field
            const createdBy = document.querySelector('input[name="created_by"]').value;
            document.getElementById('categoriesInput').value = JSON.stringify(categories.map(category => ({
                ...category,
                created_by: createdBy
            })));
        }
    </script>


@endsection
