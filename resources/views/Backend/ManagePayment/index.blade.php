@extends('backend.layouts.main')

@section('title', 'Payment List')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <!-- DataTable with Buttons -->
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary">Payment List</h4>
                        <div class="d-flex flex-wrap align-items-center">
                            <form action="{{ route('products.index') }}" method="GET"
                                class="d-flex align-items-center me-3 mb-2 mb-sm-0">
                                <div class="input-group">
                                    <input type="search" id="search-input" name="search"
                                        class="form-control-sm form-control" placeholder="Search by products name..."
                                        aria-label="Search" value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-outline-primary" id="search-button">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </div>
                            </form>
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
                                <li class="breadcrumb-item">Property/Product Management</li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('products.show', $id) }}">{{ $propertyName }}</a>
                                </li>
                                <li class="breadcrumb-item text-primary active fw-bold">Payment List</li>
                            </ol>
                        </nav>
                        <div class="card-datatable table-responsive">
                            <table class="table border-top">
                                <thead class="table-light">
                                    <tr>
                                        <th>SN</th>
                                        <th>Transaction Code</th>
                                        <th>Payment Date</th>
                                        <th>Payment Method</th>
                                        <th>Status</th>
                                        <th>Total Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="mock-test-table-body">
                                    @if ($propertyPayments->count() > 0)
                                        @foreach ($propertyPayments as $transaction_uuid => $payments)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $payments->first()->transaction_code }}</td>
                                                <td>{{ $payments->first()->payment_date }}</td>
                                                <td>{{ $payments->first()->payment_method }}</td>
                                                <td>
                                                    @php
                                                        $statusClasses = [
                                                            'PENDING' => 'bg-warning text-dark',
                                                            'COMPLETE' => 'bg-success text-white',
                                                            'FULL_REFUND' => 'bg-danger text-white',
                                                            'PARTIAL_REFUND' => 'bg-info text-white',
                                                            'CANCELLED' => 'bg-secondary text-white',
                                                            'AMBIGUOUS' => 'bg-dark text-white',
                                                            'NOT_FOUND' => 'bg-light text-dark',
                                                            'TIMEOUT' => 'bg-danger text-white',
                                                        ];
                                                        $badgeClass =
                                                            $statusClasses[$payments->first()->status] ??
                                                            'bg-secondary text-white';
                                                    @endphp
                                                    <span class="badge {{ $badgeClass }}">
                                                        <strong>{{ strtoupper(str_replace('_', ' ', $payments->first()->status)) }}</strong>
                                                    </span>
                                                </td>
                                                <td>NPR {{ number_format($payments->sum('total_amount'), 2) }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-link p-0 text-secondary"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="{{ route('property.payments.invoice', $transaction_uuid) }}"
                                                                    class="dropdown-item text-info">
                                                                    <i class="bx bx-show me-1"></i> View Invoice
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">No data available</td>
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
