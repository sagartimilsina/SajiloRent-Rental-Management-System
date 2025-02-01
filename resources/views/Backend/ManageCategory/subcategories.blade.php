@extends('backend.layouts.main')

@section('title', 'Sub Category List')

@section('content')
    <div class="container py-5">


        <div class="row">
            <div class="col-12">
                <!-- DataTable with Buttons -->
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary">
                            Product Sub Category List
                        </h4>
                        <div class="d-flex flex-wrap align-items-center">



                            <form action="{{ route('subCategories.index') }}" method="GET"
                                class="d-flex align-items-center me-3 mb-2 mb-sm-0">
                                <div class="input-group">
                                    <input type="search" id="search-input" name="search"
                                        class="form-control-sm form-control " placeholder="Search by category name..."
                                        aria-label="Search" value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-outline-primary" id="search-button">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </div>
                            </form>

                            <!-- End Search Form -->
                            <a href="{{ route('subCategories.index') }}" class="btn btn-sm btn-info ms-2 shadow-sm">
                                <i class="bx bx-refresh me-1"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-primary ms-2 shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#modalToggle" id="addCategoryclicked">
                                <i class="bx bx-plus me-1"></i>
                            </a>


                            <a href="{{ route('subCategory.trash-view') }}" class="btn btn-sm btn-danger ms-2 shadow-sm">
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
                                    Property/Product Management
                                </li>
                                <li class="breadcrumb-item text-primary active fw-bold">
                                    Product Sub Category List
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
                                        <th>Category Icon</th>
                                        @if (Auth::user()->role->role_name == 'Super Admin')
                                            <th>Created By</th>
                                        @endif
                                        <th>Publish Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="mock-test-table-body">
                                    @if ($subCategories->count() > 0)
                                        @foreach ($subCategories as $item)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->category->category_name }}</td>
                                                <td><strong>{{ $item->sub_category_name }}</strong></td>

                                                @if ($item->icon == null)
                                                    <td>No Image</td>
                                                @else
                                                    <td><img src="{{ asset('storage/' . $item->icon) }}" alt="Icon"
                                                            style="width: 50px; height: 50px; "></td>
                                                @endif
                                                @if (Auth::user()->role->role_name == 'Super Admin')
                                                    <td><strong>{{ @$item->user->name }}</strong></td>
                                                @endif


                                                @if ($item->publish_status == 1)
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
                                                            @if (Auth::user()->role->role_name != 'Super Admin' && Auth::user()->role->role_name != '')
                                                                <li>
                                                                    <button type="button"
                                                                        class="dropdown-item text-primary"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editModal{{ $item->id }}">
                                                                        <i class="bx bx-edit me-1"></i> Edit
                                                                    </button>
                                                                </li>
                                                                @if ($item->publish_status == 1)
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
                                                                            Delete Sub Category </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to delete temporarily
                                                                        <strong>{{ $item->sub_category_name }}</strong>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form
                                                                            action="{{ route('subCategory.trash', $item->id) }}"
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
                                                                    Publish Sub Category</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to publish
                                                                <strong>{{ $item->sub_category_name }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('subCategory.publish', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    @if ($item->publish_status === 0)
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
                                                                    Unpublish Sub Category</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to unpublish
                                                                <strong>{{ $item->sub_category_name }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('subCategory.unpublish', $item->id) }}"
                                                                    method="POST">
                                                                    @method('PATCH')
                                                                    @csrf
                                                                    @if ($item->publish_status === 1)
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
                                                {{-- edit modal --}}
                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                                    aria-labelledby="editModalLabel{{ $item->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editModalLabel{{ $item->id }}">Edit Category
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('subCategories.update', $item->id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="modal-body">
                                                                    <input type="hidden"
                                                                        value=" {{ auth()->user()->id }}"
                                                                        name="created_by">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label for=""
                                                                                    class="form-label">Select Category
                                                                                </label>
                                                                                <select class="form-select form-control"
                                                                                    name="category_id" id="">
                                                                                    <option selected>Select one</option>
                                                                                    @foreach ($Categories as $category)
                                                                                        <option
                                                                                            value="{{ $category->id }}"
                                                                                            {{ $item->category_id == $category->id ? 'selected' : '' }}>
                                                                                            {{ $category->category_name }}
                                                                                        </option>
                                                                                    @endforeach

                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                        <div class="mb-3 col-md-6">
                                                                            <label for="category_name_{{ $item->id }}"
                                                                                class="form-label">Sub Category
                                                                                Name</label>
                                                                            <input type="text" class="form-control"
                                                                                name="sub_category_name"
                                                                                id="category_name_{{ $item->id }}"
                                                                                value="{{ $item->sub_category_name }}"
                                                                                placeholder="Enter category name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 mb-3">
                                                                        <div class="mb-3">
                                                                            <label for="category_icon_{{ $item->id }}"
                                                                                class="form-label">Category
                                                                                Icon</label>
                                                                            <input type="file" class="form-control"
                                                                                name="icon"
                                                                                id="category_icon_{{ $item->id }}"
                                                                                accept="image/*">
                                                                            <small class="text-muted">Leave empty if
                                                                                you don't
                                                                                want to change the icon.</small>
                                                                        </div>

                                                                        <!-- Image Preview Section -->
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Selected Icon
                                                                                Preview:</label>
                                                                            <div>
                                                                                <img id="iconPreview_{{ $item->id }}"
                                                                                    src="{{ asset('storage/' . $item->icon) }}"
                                                                                    alt="Current Category Icon"
                                                                                    style="width: 100px; height: 100px; ">
                                                                            </div>
                                                                        </div>

                                                                        <script>
                                                                            // Event listener to preview the image when a user selects a file
                                                                            document.getElementById('category_icon_{{ $item->id }}').addEventListener('change', function(event) {
                                                                                const file = event.target.files[0];
                                                                                const preview = document.getElementById('iconPreview_{{ $item->id }}');

                                                                                if (file) {
                                                                                    const reader = new FileReader();

                                                                                    reader.onload = function(e) {
                                                                                        preview.src = e.target.result;
                                                                                    };

                                                                                    reader.readAsDataURL(file);
                                                                                } else {
                                                                                    preview.src =
                                                                                        "{{ asset('storage/' . $item->icon) }}"; // Fallback to the current icon if no file selected
                                                                                }
                                                                            });
                                                                        </script>
                                                                    </div>


                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-sm">Save
                                                                        Changes</button>
                                                                    <button type="button"
                                                                        class="btn btn-secondary btn-sm"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </form>
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
                                {{ $subCategories->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalToggle" tabindex="-1" aria-labelledby="modalToggleLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalToggleLabel">Add Product Sub Categories</h5>
                    {{-- <button type="button" class="btn-close" aria-label="Close"></button> --}}
                </div>
                <form action="{{ route('subCategories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label"> Select Category
                                    </label>
                                    <select class="form-select form-select" name="category_id" id="categorySelect">
                                        <option selected>Select one</option>
                                        @foreach ($Categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="category_name" class="form-label">Sub Category Name</label>
                                <input type="text" class="form-control" name="sub_category_name" id="category_name"
                                    placeholder="Enter category name">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="category_icon" class="form-label">Sub Category Icon</label>
                                <input type="file" class="form-control" name="icon" id="category_icon"
                                    accept="image/*">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm" id="addCategory">Add Sub Category</button>
                        <hr>
                        <h5>Added Categories</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th>Sub Category Name</th>
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

    {{-- <script>
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
            const categorySelect = document.getElementById('categorySelect');

            if (!nameInput.value || categorySelect.value === 'Select one') {
                alert('Category name and category must be selected!');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                // Add category to the array
                categories.push({
                    category_id: categorySelect.value,
                    category_name: categorySelect.options[categorySelect.selectedIndex].text,
                    sub_category_name: nameInput.value,
                    icon: e.target.result
                });

                // Render categories in the table
                renderCategories();

                // Reset input fields
                nameInput.value = '';
                iconInput.value = '';
                categorySelect.value = 'Select one';
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
                    <td>${category.category_name}</td>
                    <td>${category.sub_category_name}</td>
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
    </script> --}}
    <script>
        let categories = []; // Define the categories array globally

        document.getElementById('addCategory').addEventListener('click', function() {
            const nameInput = document.getElementById('category_name');
            const iconInput = document.getElementById('category_icon');
            const categorySelect = document.getElementById('categorySelect');

            if (!nameInput.value || categorySelect.value === 'Select one') {
                alert('Category name and category must be selected!');
                return;
            }

            const categoryData = {
                category_id: categorySelect.value,
                category_name: categorySelect.options[categorySelect.selectedIndex].text,
                sub_category_name: nameInput.value,
                icon: null // Default null for optional icon
            };

            if (iconInput.files.length > 0) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    categoryData.icon = e.target.result; // Assign base64 image if available
                    addCategoryToTable(categoryData);
                };
                reader.readAsDataURL(iconInput.files[0]);
            } else {
                addCategoryToTable(categoryData);
            }
        });

        function addCategoryToTable(categoryData) {
            categories.push(categoryData);
            renderCategories();
        }

        function removeCategory(index) {
            categories.splice(index, 1);
            renderCategories();
        }

        function renderCategories() {
            const tableBody = document.getElementById('categoryTable');
            tableBody.innerHTML = '';

            categories.forEach((category, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${category.category_name}</td>
                    <td>${category.sub_category_name}</td>
                    <td>
                        ${category.icon ? `<img src="${category.icon}" alt="Icon" style="width: 50px; height: 50px; object-fit: cover;">` : 'No Image'}
                    </td>
                    <td><button class="btn btn-danger btn-sm" onclick="removeCategory(${index})">Remove</button></td>
                `;
                tableBody.appendChild(row);
            });

            const createdBy = document.querySelector('input[name="created_by"]').value;
            document.getElementById('categoriesInput').value = JSON.stringify(
                categories.map(category => ({
                    ...category,
                    created_by: createdBy
                }))
            );
        }
    </script>




@endsection
