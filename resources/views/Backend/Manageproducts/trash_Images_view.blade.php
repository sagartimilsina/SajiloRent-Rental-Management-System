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
                            
                            <a href="{{ route('products.images', $id) }}" class="btn btn-sm btn-danger ms-2 shadow-sm">
                                <i class="bx bx-arrow-back me-1"></i>
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Breadcrumb Navigation -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style1 py-3">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item">Property/Product Management</li>
                                <li class="breadcrumb-item text-primary active fw-bold">Images List</li>
                                <li class="breadcrumb-item text-primary active fw-bold">Trash</li>
                            </ol>
                        </nav>

                        <div class="row">
                            @foreach ($blogs_trash as $image)
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <img class="card-img-top" src="{{ asset('storage/' . $image->property_image) }}"
                                            alt="Image" />
                                        <div class="card-body text-center">
                                            <button class="btn btn-sm  btn-info" data-bs-toggle="modal"
                                                data-bs-target="#restoreModal{{ $image->id }}">
                                                <i class="bx bx-undo me-1 text-white"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $image->id }}">
                                                <i class="bx bx-trash" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Publish Modal -->
                                <div class="modal fade" id="restoreModal{{ $image->id }}" tabindex="-1"
                                    aria-labelledby="restoreModalLabel{{ $image->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="restoreModalLabel{{ $image->id }}">Restore
                                                </h5> <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to restore
                                                <strong>{{ $image->property_name }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('property-image.restore', $image->id) }}" method="GET">
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
                                <div class="modal fade" id="deleteModal{{ $image->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel{{ $image->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $image->id }}">
                                                    Delete Property</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete permanently
                                                <strong>{{ $image->property_name }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('property-images.destroy', $image->id) }}" method="POST">
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






@endsection
