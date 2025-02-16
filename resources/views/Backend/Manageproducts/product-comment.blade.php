@extends('backend.layouts.main')

@section('title', 'Product Review List')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <!-- DataTable with Buttons -->
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary">
                            Product Review List
                        </h4>
                        <div class="d-flex flex-wrap align-items-center">


                            <!-- End Search Form -->
                            <a href="{{ route('products.index') }}" class="btn btn-sm btn-info ms-2 shadow-sm">
                                <i class="bx bx-arrow-back me-1"></i>
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

                                <li class="breadcrumb-item ">
                                    <a href="{{ route('products.show', $propertyId) }}">
                                        {{ $propertyName }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item text-primary active fw-bold">
                                    Product Review List
                                </li>
                            </ol>
                        </nav>
                        <div class="card-datatable table-responsive">
                            <table class="table border-top">
                                <thead class="table-light">
                                    <tr>
                                        <th>SN</th>

                                        <th>Product Title</th>
                                        @if (Auth::user()->role->role_name == 'Super Admin')
                                            <th>Created By</th>
                                        @endif
                                        <th>Rated By</th>
                                        <th>Rating</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="mock-test-table-body">
                                    @if (isset($propertyReviews) && count($propertyReviews) > 0)
                                        @foreach ($propertyReviews as $item)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration }}</td>

                                                <td>{{ $item['property']['property_name'] }}</td>

                                                @if (Auth::user()->role->role_name == 'Super Admin')
                                                    <td><strong>{{ $item['property']['created_by'] }}</strong></td>
                                                @endif

                                                <td><strong>{{ $item['user']['name'] }}</strong></td>
                                                <td>
                                                    <!-- Display Stars Instead of Numbers -->
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $item['property_rating'])
                                                            <i class="bx bxs-star text-warning"></i>
                                                        @else
                                                            <i class="bx bx-star text-secondary"></i>
                                                        @endif
                                                    @endfor
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-link p-0 text-secondary"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <button class="dropdown-item text-info"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#reviewModal{{ $item['id'] }}">
                                                                    <i class="bx bx-show me-1"></i> View Review
                                                                </button>
                                                            </li>

                                                            <li>
                                                                <button type="button" class="dropdown-item text-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deleteModal{{ $item['id'] }}">
                                                                    <i class="bx bx-trash me-1"></i> Delete
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <!-- Review Modal -->
                                                    <div class="modal fade" id="reviewModal{{ $item['id'] }}"
                                                        tabindex="-1"
                                                        aria-labelledby="reviewModalLabel{{ $item['id'] }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="reviewModalLabel{{ $item['id'] }}">
                                                                        Review by {{ $item['user']['name'] }}
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>Rating:</strong></p>
                                                                    <div>
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            @if ($i <= $item['property_rating'])
                                                                                <i class="bx bxs-star text-warning"></i>
                                                                            @else
                                                                                <i class="bx bx-star text-secondary"></i>
                                                                            @endif
                                                                        @endfor
                                                                    </div>
                                                                    <p><strong>Review:</strong></p>
                                                                    <p>{{ $item['property_review'] }}</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="deleteModal{{ $item['id'] }}"
                                                        tabindex="-1"
                                                        aria-labelledby="deleteModalLabel{{ $item['id'] }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="deleteModalLabel{{ $item['id'] }}">Delete
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete permanently
                                                                    <strong>{{ $item['property']['property_name'] }}</strong>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form
                                                                        action="{{ route('property.review.delete', $item['id']) }}"
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
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center">No data available</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
