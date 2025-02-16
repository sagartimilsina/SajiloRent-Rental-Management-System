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
                            Product Message List
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
                                    <a href="{{ route('products.show', $id) }}">
                                        {{ $propertyName }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item text-primary active fw-bold">
                                    Product Message List
                                </li>
                            </ol>
                        </nav>
                        <div class="card-datatable table-responsive">
                            <table class="table border-top">
                                <thead class="table-light">
                                    <tr>
                                        <th>SN</th>
                                        <th>Product Title</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Subject</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="mock-test-table-body">
                                    @if (isset($property_message) && count($property_message) > 0)
                                        @foreach ($property_message as $item)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration }}</td>

                                                <td>{{ $item['property']['property_name'] }}</td>


                                                <td><strong>{{ $item['user']['name'] }}</strong></td>
                                                <td><strong>{{ $item['user']['email'] }}</strong></td>
                                                <td><strong>{{ $item['user']['phone'] }}</strong></td>
                                                <td><strong>{{ $item['subject'] }}</strong></td>

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
                                                                    <i class="bx bx-show me-1"></i> View Message
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
                                                                        Message by {{ $item['user']['name'] }}
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>{{ $item['message'] }}</p>
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
                                                                    Are you sure you want to delete permanently this message
                                                                    <strong>{{ $item['property']['property_name'] }}</strong>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form
                                                                        action="{{ route('property.message.delete', $item['id']) }}"
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
