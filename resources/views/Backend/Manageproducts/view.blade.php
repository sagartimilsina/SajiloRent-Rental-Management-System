@extends('backend.layouts.main')

@section('title', 'View Product')

@section('content')
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between  ">
                        <h5 class="mb-0 text-primary">View Product</h5>
                        @if (Auth::user()->role->role_name == 'Super Admin')
                            <a href="{{ route('superadmin.property.index') }}" class="btn btn-primary btn-sm me-2">
                                <i class="fa fa-arrow-left me-2" aria-hidden="true"></i> Back
                            </a>
                        @elseif(Auth::user()->role->role_name == 'Admin')
                            <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm me-2">
                                <i class="fa fa-arrow-left me-2" aria-hidden="true"></i> Back
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb py-3 mb-4 bg-light">
                                @if (Auth::user()->role->role_name == 'Super Admin')
                                    <li class="breadcrumb-item"><a href="{{ route('super.admin.dashboard') }}">Dashboard</a>
                                    </li>
                                @elseif (Auth::user()->role->role_name == 'Admin')
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                @endif
                                <li class="breadcrumb-item">Property/Product Management</li>
                                <li class="breadcrumb-item active text-primary">View Product</li>
                            </ol>
                        </nav>

                        <!-- Product Details -->
                        <div class="row">
                            <!-- Category -->
                            <div class="form-group col-md-3 mb-3">
                                <label for="category" class="form-label">Category</label>
                                <p class="form-control bg-light" readonly>
                                    {{ $Categories->firstWhere('id', $product->category_id)->category_name ?? 'N/A' }}
                                </p>
                            </div>

                            <!-- Sub Category -->
                            <div class="form-group col-md-3 mb-3">
                                <label for="sub_category" class="form-label">Sub Category</label>
                                <p class="form-control bg-light" readonly>
                                    {{ $subCategories->firstWhere('id', $product->sub_category_id)->sub_category_name ?? 'N/A' }}
                                </p>
                            </div>

                            <!-- Property Name -->
                            <div class="form-group col-md-3 mb-3">
                                <label for="property_name" class="form-label">Property Name</label>
                                <p class="form-control bg-light" readonly>{{ $product->property_name ?? 'N/A' }}</p>
                            </div>

                            <!-- Thumbnail -->
                            <div class="form-group col-md-3 mb-3">
                                <label for="thumbnail" class="form-label">Thumbnail</label>
                                <div class="text-center">
                                    <img id="imagePreview"
                                        src="{{ $product->property_image ? asset('storage/' . $product->property_image) : asset('images/no-image.png') }}"
                                        alt="Thumbnail" class="img-thumbnail" style="max-width: auto; max-height: auto;">
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Information -->
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <label class="form-label">Pricing</label>
                                <table class="table table-bordered bg-light">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Normal Price</th>
                                            <th>Discount Price</th>
                                            <th>Selling Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $product->property_price ?? 'N/A' }}</td>
                                            <td>{{ $product->property_discount ?? 'N/A' }}</td>
                                            <td>{{ $product->property_sell_price ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Additional Details -->
                        <div class="row">
                            <div class="form-group col-md-9 mb-3">
                                <label class="form-label">Location</label>
                                <p class="form-control bg-light" readonly>{{ $product->property_location ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label class="form-label">Quantity</label>
                                <p class="form-control bg-light" readonly>{{ $product->property_quantity ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="form-group mb-3 col-md-12">
                            <label for="map_link" class="form-label">Property Location Map Link</label>
                            <input type="text" id="map_link" name="map_link"
                                class="form-control @error('map_link') is-invalid @enderror"
                                value="{{ old('map_link', isset($product) ? $product->map_link : '') }}" required autofocus
                                placeholder="Enter property location map link">
                            @error('map_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" class="form-control bg-light" rows="4" readonly>{{ $product->property_description ?? 'N/A' }}</textarea>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: 'Enter a detailed description...',
                tabsize: 2,
                height: 200,
            });
        });
    </script>
@endsection
