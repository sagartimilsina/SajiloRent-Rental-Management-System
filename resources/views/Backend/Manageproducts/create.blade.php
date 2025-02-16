@extends('backend.layouts.main')

@section('title', isset($product) ? 'Edit product' : 'Create product')

@section('content')
    <style>
        .input-group {
            gap: 10px;
            margin-bottom: 1rem;
        }

        .table {
            margin-top: 1rem;
        }

        #pricingDetails {
            display: none;
        }
    </style>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 text-primary">{{ isset($product) ? 'Edit product' : 'Create product' }}</h5>
                        <div class="d-flex align-items-center">

                            <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm ms-3 "> <i
                                    class="fa fa-arrow-left me-2" aria-hidden="true"></i> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style1 py-3">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item ">
                                    Property/Product Management
                                </li>
                                <li class="breadcrumb-item text-primary  active">
                                    Product List
                                </li>
                                <li class="breadcrumb-item text-primary active fw-bold">
                                    {{ isset($product) ? 'Edit product' : 'Create product' }}
                                </li>
                            </ol>
                        </nav>
                        <form id="product-form"
                            action="{{ isset($product) ? route('products.update', ['product' => $product->id]) : route('products.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($product))
                                @method('PUT')
                            @endif
                            <!-- Name Input -->
                            <div class="row">
                                {{-- <div class="form-group col-md-3 mb-3">
                                    <label for="" class="form-label">Select Category</label>
                                    <select
                                        class="form-select form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}"
                                        name="category_id" id="">
                                        <option selected>Select one Category</option>
                                        @foreach ($Categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', isset($product) ? $product->category_id : '') == $category->id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('category_id') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col-md-3 mb-3">
                                    <label for="" class="form-label">Select Sub Category</label>
                                    <select
                                        class="form-select form-control {{ $errors->has('sub_category_id') ? 'is-invalid' : '' }}"
                                        name="sub_category_id" id="">
                                        <option selected>Select Sub Category</option>
                                        @foreach ($subCategories as $subcategory)
                                            <option value="{{ $subcategory->id }}"
                                                {{ old('sub_category_id', isset($product) ? $product->sub_category_id : '') == $subcategory->id ? 'selected' : '' }}>
                                                {{ $subcategory->sub_category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('sub_category_id'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('sub_category_id') }}
                                        </div>
                                    @endif
                                </div> --}}
                                <div class="form-group col-md-3 mb-3">
                                    <label for="" class="form-label">Select Category</label>
                                    <select
                                        class="form-select form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}"
                                        name="category_id" id="categorySelect">
                                        <option selected>Select one Category</option>
                                        @foreach ($Categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', isset($product) ? $product->category_id : '') == $category->id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('category_id') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group col-md-3 mb-3">
                                    <label for="" class="form-label">Select Sub Category</label>
                                    <select
                                        class="form-select form-control {{ $errors->has('sub_category_id') ? 'is-invalid' : '' }}"
                                        name="sub_category_id" id="subCategorySelect">
                                        <option selected>Select Sub Category</option>
                                    </select>
                                    @if ($errors->has('sub_category_id'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('sub_category_id') }}
                                        </div>
                                    @endif
                                </div>

                                <script>
                                    document.getElementById('categorySelect').addEventListener('change', function() {
                                        let categoryId = this.value;
                                        let subCategorySelect = document.getElementById('subCategorySelect');

                                        subCategorySelect.innerHTML = '<option selected>Loading...</option>'; // Show loading text

                                        if (categoryId) {
                                            fetch(`/get-subcategories/${categoryId}`)
                                                .then(response => response.json())
                                                .then(data => {
                                                    subCategorySelect.innerHTML = '<option selected>Select Sub Category</option>';
                                                    data.forEach(subCategory => {
                                                        subCategorySelect.innerHTML +=
                                                            `<option value="${subCategory.id}">${subCategory.sub_category_name}</option>`;
                                                    });
                                                })
                                                .catch(error => {
                                                    console.error('Error fetching subcategories:', error);
                                                    subCategorySelect.innerHTML = '<option selected>Error loading subcategories</option>';
                                                });
                                        } else {
                                            subCategorySelect.innerHTML = '<option selected>Select Sub Category</option>';
                                        }
                                    });
                                </script>

                                <div class="form-group mb-3 col-md-3">
                                    <label for="property_name" class="form-label">Property Name</label>
                                    <input type="text" id="property_name" name="property_name"
                                        class="form-control @error('property_name') is-invalid @enderror"
                                        value="{{ old('property_name', isset($product) ? $product->property_name : '') }}"
                                        required autofocus placeholder="Enter property name">
                                    @error('property_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label for="thumbnail" class="form-label">Thumbnail</label>
                                    <input type="file" id="thumbnail" name="thumbnail"
                                        class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                                    @error('thumbnail')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <img id="imagePreview"
                                        src="{{ isset($product) && $product->property_image ? asset('storage/' . $product->property_image) : '' }}"
                                        alt="Image Preview"
                                        style="display: {{ isset($product->property_image) ? 'block' : 'none' }}; margin-top: 10px; max-width: 200px; max-height: 150px; object-fit: cover;" />
                                </div>
                                <div class="pricing-container form-group mb-3 col-md-6">
                                    <label for="pricingType" class="form-label">Pricing Type</label>
                                    <div class="mb-3">
                                        <select class="form-select form-control" id="pricingType" name="pricing_type"
                                            onchange="togglePricingDetails()">
                                            <option value="free"
                                                {{ old('pricing_type', isset($product) ? $product->pricing_type : '') == 'free' ? 'selected' : '' }}>
                                                Free
                                            </option>
                                            <option value="paid"
                                                {{ old('pricing_type', isset($product) ? $product->pricing_type : '') == 'paid' ? 'selected' : '' }}>
                                                Paid
                                            </option>
                                        </select>
                                    </div>
                                    <div id="pricingDetails"
                                        style="display: {{ old('pricing_type', isset($product) ? $product->pricing_type : '') === 'paid' ? 'block' : 'none' }};">
                                        <div class="input-group d-flex flex-wrap">
                                            <input type="number" class="form-control" name="normal_price" id="normalPrice"
                                                placeholder="Normal Price"
                                                value="{{ old('normal_price', isset($product) ? $product->property_price : '') }}">
                                            <input type="number" class="form-control" name="sell_price" id="sellPrice"
                                                placeholder="Discount Price"
                                                value="{{ old('sell_price', isset($product) ? $product->property_sell_price : '') }}">
                                            <button type="button" class="btn btn-primary"
                                                onclick="addPricing()">Add</button>
                                        </div>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Normal Price</th>
                                                    <th>Sell Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="pricingTable">
                                            </tbody>
                                            <input type="hidden" name="pricings" id="pricingsInput">
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group mb-3 col-md-3">
                                    <label for="property_location" class="form-label">Property Location</label>
                                    <input type="text" id="property_location" name="property_location"
                                        class="form-control @error('property_location') is-invalid @enderror"
                                        value="{{ old('property_location', isset($product) ? $product->property_location : '') }}"
                                        required autofocus placeholder="Enter property location">
                                    @error('property_location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3 col-md-3">
                                    <label for="map_link" class="form-label">Property Location Map Link</label>
                                    <input type="text" id="map_link" name="map_link"
                                        class="form-control @error('map_link') is-invalid @enderror"
                                        value="{{ old('map_link', isset($product) ? $product->map_link : '') }}" required
                                        autofocus placeholder="Enter property location">
                                    @error('map_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3 col-md-3">
                                    <label for="property_quantity" class="form-label">Property Quantity</label>
                                    <input type="number" id="property_quantity" name="property_quantity"
                                        class="form-control @error('property_quantity') is-invalid @enderror"
                                        value="{{ old('property_quantity', isset($product) ? $product->property_quantity : '') }}"
                                        required autofocus placeholder="Enter property quantity">
                                    @error('property_quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description Textarea -->
                            <div class="form-group mb-3 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', isset($product) ? $product->property_description : '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ isset($product) ? 'Update product' : 'Create product' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for cropping image -->
    <div class="modal fade" id="cropper-modal" tabindex="-1" role="dialog" aria-labelledby="cropperModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cropperModalLabel">Crop Image</h5>
                    <button type="button" class="btn btn-secondary" id="close-modal">Cancel</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="img-container">
                                <img id="cropper-image" src=""
                                    style="width: 100%; max-height: 600px; object-fit: contain;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="preview-container mt-3">
                                <h6>Live Preview:</h6>
                                <div class="preview" style="width: 150px; height: 150px; overflow: hidden;">
                                    <img id="preview-image" style="max-width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="crop-button">Crop</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Check initial pricing type on page load
            togglePricingDetails();
        });

        function togglePricingDetails() {
            const pricingType = document.getElementById('pricingType').value;
            const pricingDetails = document.getElementById('pricingDetails');

            if (pricingType === 'paid') {
                pricingDetails.style.display = 'block';
            } else {
                pricingDetails.style.display = 'none';
                clearPricingTable(); // Clear the table and hidden input if 'Free' is selected
            }
        }

        function addPricing() {
            const normalPrice = document.getElementById('normalPrice').value;
            const sellPrice = document.getElementById('sellPrice').value;

            // Ensure both prices are entered
            if (!normalPrice || !sellPrice) {
                alert('Please fill in all required fields');
                return;
            }

            const tableBody = document.getElementById('pricingTable');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${normalPrice}</td>
                <td>${sellPrice}</td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="deletePricingRow(this)">Delete</button>
                </td>
            `;
            tableBody.appendChild(newRow);

            // Clear inputs
            document.getElementById('normalPrice').value = '';
            document.getElementById('sellPrice').value = '';

            // Update hidden input field
            updateHiddenInput();
        }

        function deletePricingRow(button) {
            const row = button.closest('tr');
            row.remove();
            updateHiddenInput();
        }

        function clearPricingTable() {
            const tableBody = document.getElementById('pricingTable');
            tableBody.innerHTML = '';
            updateHiddenInput();
        }

        function updateHiddenInput() {
            const tableBody = document.getElementById('pricingTable');
            const rows = Array.from(tableBody.children);
            const pricingData = rows.map(row => ({
                normal_price: row.children[0].textContent.trim(),
                sell_price: row.children[1].textContent.trim(),
            }));
            document.getElementById('pricingsInput').value = JSON.stringify(pricingData);
        }
    </script>



    <!-- jQuery and Cropper.js scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.js"></script>
    <script>
        $(document).ready(function() {
            var $modal = $('#cropper-modal');
            var image = document.getElementById('cropper-image');
            var cropper;

            $('#thumbnail').change(function(e) {
                var files = e.target.files;
                if (files && files.length > 0) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        image.src = event.target.result;
                        $modal.modal('show');
                    };
                    reader.readAsDataURL(files[0]);
                }
            });

            $modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 1.5,
                    viewMode: 3,
                    preview: '.preview',
                    autoCropArea: 1,
                    responsive: true,
                });
            }).on('hidden.bs.modal', function() {
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
            });

            $('#crop-button').click(function() {
                if (!cropper) return;

                var canvas = cropper.getCroppedCanvas({
                    width: 1024,
                    height: 1024
                });

                canvas.toBlob(function(blob) {
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        var base64data = reader.result;
                        $('#imagePreview').attr('src', base64data).show();
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'cropped_image',
                            value: base64data
                        }).appendTo('#product-form');
                        $modal.modal('hide');
                    };
                });
            });

            $('#close-modal').click(function() {
                $modal.modal('hide');
            });

            // Summernote Initialization
            $('#description').summernote({
                placeholder: 'Enter a detailed description...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
@endsection
