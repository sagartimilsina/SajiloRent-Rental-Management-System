@extends('backend.layouts.main')

@section('title', 'Property Images List')

@section('content')
    <div class="container py-3">
        <div class="row">
            <div class="col-12">
                <!-- DataTable with Buttons -->
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary">Property Images List</h4>
                        <div class="d-flex flex-wrap align-items-center">
                            <a href="{{ route('products.index') }}" class="btn btn-sm btn-info ms-2 shadow-sm">
                                <i class="bx bx-arrow-back me-1"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-primary ms-2 shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#modalToggle">
                                <i class="bx bx-plus me-1"></i>
                            </a>

                            <a href="{{ route('property-images.trash-view', $property->id) }}"
                                class="btn btn-sm btn-danger ms-2 shadow-sm">
                                <i class="bx bx-trash me-1"></i>
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Breadcrumb Navigation -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style1 py-3">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item">Property/Product Management</li>

                                <li class="breadcrumb-item text-primary active fw-bold"> <a
                                        href="{{ route('products.index', $property->id) }}">{{ $property->property_name }}
                                    </a></li>

                                <li class="breadcrumb-item text-primary active fw-bold">Images List</li>
                            </ol>
                        </nav>

                        <div class="row">
                            @foreach ($property_images as $image)
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <img class="card-img-top" src="{{ asset('storage/' . $image->property_image) }}"
                                            alt="Image" />
                                        <div class="card-body text-center">
                                            @if ($image->property_publish_status == 1)
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#unpublishModal{{ $image->id }}">
                                                    <i class="bx bx-x-circle" aria-hidden="true"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#publishModal{{ $image->id }}">
                                                    <i class="bx bx-check-circle" aria-hidden="true"></i>
                                                </button>
                                            @endif
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $image->id }}">
                                                <i class="bx bx-trash" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Publish Modal -->
                                <div class="modal fade" id="publishModal{{ $image->id }}" tabindex="-1"
                                    aria-labelledby="publishModalLabel{{ $image->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="publishModalLabel{{ $image->id }}">
                                                    Publish Property Images</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to publish
                                                ?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('property-image.publish', $image->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    @if ($image->property_publish_status === 0)
                                                        <input type="hidden" name="publish_status" value="1">
                                                    @endif
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-success">Publish</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Unpublish Modal -->
                                <div class="modal fade" id="unpublishModal{{ $image->id }}" tabindex="-1"
                                    aria-labelledby="unpublishModalLabel{{ $image->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="unpublishModalLabel{{ $image->id }}">
                                                    Unpublish Property Images</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to unpublish
                                                ?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('property-image.unpublish', $image->id) }}"
                                                    method="POST">
                                                    @method('PATCH')
                                                    @csrf
                                                    @if ($image->property_publish_status === 1)
                                                        <input type="hidden" name="publish_status" value="0">
                                                    @endif
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Unpublish</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="deleteModal{{ $image->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel{{ $image->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $image->id }}">
                                                    Delete </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete temporarily
                                                <strong></strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('property-image.trash', $image->id) }}"
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal HTML for Image Upload -->
    <div class="modal fade" id="modalToggle" tabindex="-1" aria-labelledby="modalToggleLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" style="height: 80vh;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalToggleLabel">Add Images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="clearImages()"></button>
                </div>
                <form id="product-form" action="{{ route('property-images.store', ['product' => $property->id]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="property_id" value="{{ $property->id ?? '' }}">

                    <!-- Image upload drag and drop -->
                    <div class="form-group m-auto p-3">
                        <label for="images" class="form-label">Upload Images</label>
                        <input type="file" id="images" name="images[]" class="form-control" accept="image/*"
                            multiple>
                        <div id="image-previews" class="mt-2 d-flex flex-wrap"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Save Images
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            onclick="clearImages()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for Image Preview and Upload Handling -->
    <script>
        // Custom array to track selected files
        let selectedFiles = [];

        document.getElementById("images").addEventListener("change", (event) => {
            const files = event.target.files;
            if (files.length < 1 || files.length > 15) {
                alert("Please select between 1 and 15 images.");
                event.target.value = ""; // Clear the input field
                clearImages(); // Clear previews
                return;
            }
            selectedFiles = [...files]; // Update custom array
            previewFiles(selectedFiles);
        });

        // Drag-and-drop functionality with custom array sync
        const dropArea = document.getElementById("image-previews");
        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropArea.classList.add('border', 'border-primary', 'border-dashed');
        });
        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('border', 'border-primary', 'border-dashed');
        });
        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.classList.remove('border', 'border-primary', 'border-dashed');
            const files = e.dataTransfer.files;
            if (files.length + selectedFiles.length > 15) {
                alert("You can upload a maximum of 15 images.");
                return;
            }
            selectedFiles = [...selectedFiles, ...files];
            previewFiles(selectedFiles);
        });

        // Function for previewing selected or dropped files
        function previewFiles(files) {
            const previewArea = document.getElementById('image-previews');
            previewArea.innerHTML = ""; // Clear existing previews

            files.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('position-relative', 'm-2');
                    imgContainer.dataset.index = index;

                    const img = document.createElement('img');
                    img.classList.add('img-fluid');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';

                    const removeBtn = document.createElement('button');
                    removeBtn.classList.add('btn', 'btn-sm', 'btn-danger', 'position-absolute', 'top-0',
                        'start-100', 'translate-middle');
                    removeBtn.style.zIndex = '999';
                    removeBtn.innerText = '×';
                    removeBtn.addEventListener('click', () => removeImage(index));

                    imgContainer.appendChild(img);
                    imgContainer.appendChild(removeBtn);
                    previewArea.appendChild(imgContainer);
                };
                reader.readAsDataURL(file);
            });
        }

        // Remove image from preview and custom array
        function removeImage(index) {
            selectedFiles.splice(index, 1); // Remove the file from the custom array
            previewFiles(selectedFiles); // Re-render the previews
            syncInputFiles(); // Update the input files to reflect changes
        }

        // Clear image previews and reset custom array
        function clearImages() {
            selectedFiles = [];
            const previewArea = document.getElementById('image-previews');
            previewArea.innerHTML = "";
            syncInputFiles();
        }

        // Sync custom array with the input element
        function syncInputFiles() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            document.getElementById("images").files = dataTransfer.files;
        }

        // Form submission validation
        document.getElementById("product-form").addEventListener("submit", (e) => {
            if (selectedFiles.length < 1 || selectedFiles.length > 15) {
                alert("Please select between 1 and 15 images before submitting.");
                e.preventDefault();
            }
        });
    </script>


@endsection
