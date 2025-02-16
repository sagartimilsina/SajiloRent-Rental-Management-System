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
                        <h5 class="mb-0 text-primary">{{ isset($product) ? 'Edit Contract ' : 'Save Contract' }}</h5>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('property-contracts.index') }}" class="btn btn-primary btn-sm ms-3">
                                <i class="fa fa-arrow-left me-2" aria-hidden="true"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style1 py-3">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">Manage Contracts</li>
                                <li class="breadcrumb-item text-primary active">Contract List</li>
                                <li class="breadcrumb-item text-primary active fw-bold">
                                    {{ isset($product) ? 'Edit Contract' : 'Save Contract' }}
                                </li>
                            </ol>
                        </nav>
                        <form id="contract-form"
                            action="{{ isset($contract) ? route('property-contracts.update', ['property_contract' => $contract->id]) : route('property-contracts.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($contract))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <!-- Product Selection -->
                                <div class="form-group col-md-6 mb-3">
                                    <label for="product_id" class="form-label">Select Product</label>
                                    <select id="product_id" name="property_id"
                                        class="form-control @error('property_id') is-invalid @enderror" required>
                                        <option value="">Select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('product_id', $contract->property_id ?? '') == $product->id ? 'selected' : '' }}>
                                                {{ $product->property_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('property_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- User Selection -->
                                <div class="form-group col-md-6 mb-3">
                                    <label for="user_id" class="form-label">Select User</label>
                                    <select id="user_id" name="user_id"
                                        class="form-control @error('user_id') is-invalid @enderror" required>
                                        <option value="">Select User</option>
                                        @if (@$contract)
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ old('user_id', $contract->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <!-- Contract Type -->
                                <div class="form-group col-md-6 mb-3">
                                    <label for="contract_type" class="form-label">Contract Type</label>
                                    <select class="form-select form-control @error('contract_type') is-invalid @enderror"
                                        name="contract_type" required>
                                        <option value="">Select Contract Type</option>
                                        <option value="rental"
                                            {{ old('contract_type', $contract->contract_type ?? '') == 'rental' ? 'selected' : '' }}>
                                            Rental</option>
                                        <option value="lease"
                                            {{ old('contract_type', $contract->contract_type ?? '') == 'lease' ? 'selected' : '' }}>
                                            Lease</option>
                                        <option value="sale"
                                            {{ old('contract_type', $contract->contract_type ?? '') == 'sale' ? 'selected' : '' }}>
                                            Sale</option>
                                    </select>
                                    @error('contract_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Contract Start Date -->
                                <div class="form-group col-md-6 mb-3">
                                    <label for="contract_start_date" class="form-label">Start Date</label>
                                    <input type="date" id="contract_start_date" name="contract_start_date"
                                        class="form-control @error('contract_start_date') is-invalid @enderror"
                                        value="{{ old('contract_start_date', $contract->contract_start_date ?? '') }}"
                                        required>
                                    @error('contract_start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Contract End Date -->
                                <div class="form-group col-md-6 mb-3">
                                    <label for="contract_end_date" class="form-label">End Date</label>
                                    <input type="date" id="contract_end_date" name="contract_end_date"
                                        class="form-control @error('contract_end_date') is-invalid @enderror"
                                        value="{{ old('contract_end_date', $contract->contract_end_date ?? '') }}"
                                        required>
                                    @error('contract_end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Upload Contract File -->
                                <div class="form-group col-md-6 mb-3">
                                    <label for="contract_file" class="form-label">Upload Contract</label>
                                    <input type="file" id="contract_file" name="contract_file"
                                        class="form-control @error('contract_file') is-invalid @enderror"
                                        accept=".pdf,.doc,.docx">
                                    @error('contract_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if (isset($contract) && $contract->contract_file)
                                        @php $fileUrl = asset('storage/'.$contract->contract_file); @endphp

                                        <p>
                                            <a href="{{ $fileUrl }}" class="btn btn-primary btn-sm mt-2"
                                                target="_blank">View Current Contract</a>
                                        </p>
                                    @else
                                        <p>No contract file available.</p>
                                    @endif

                                </div>

                                <!-- Contract Status -->
                                <div class="form-group col-md-6 mb-3">
                                    <label for="contract_status" class="form-label">Contract Status</label>
                                    <select class="form-select form-control @error('contract_status') is-invalid @enderror"
                                        name="contract_status">
                                        <option value="pending"
                                            {{ old('contract_status', $contract->contract_status ?? '') == 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="approved"
                                            {{ old('contract_status', $contract->contract_status ?? '') == 'approved' ? 'selected' : '' }}>
                                            Approved
                                        </option>
                                        <option value="rejected"
                                            {{ old('contract_status', $contract->contract_status ?? '') == 'rejected' ? 'selected' : '' }}>
                                            Rejected
                                        </option>
                                        <option value="cancelled"
                                            {{ old('contract_status', $contract->contract_status ?? '') == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled
                                        </option>
                                        <option value="completed"
                                            {{ old('contract_status', $contract->contract_status ?? '') == 'completed' ? 'selected' : '' }}>
                                            Completed
                                        </option>
                                        <option value="expired"
                                            {{ old('contract_status', $contract->contract_status ?? '') == 'expired' ? 'selected' : '' }}>
                                            Expired
                                        </option>
                                    </select>
                                    @error('contract_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ isset($contract) ? 'Update Contract' : 'Create Contract' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script>
        $(document).ready(function() {
            // Handle product selection change
            $('#product_id').on('change', function() {
                const productId = $(this).val();
                const userSelect = $('#user_id');

                // Reset user dropdown
                userSelect.empty().append('<option value="">Select User</option>');

                if (productId) {
                    // Show loading state
                    userSelect.prop('disabled', true);

                    $.ajax({
                        url: "{{ route('fetch.paid.users', ['productId' => ':productId']) }}"
                            .replace(':productId', productId),
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success && response.users.length > 0) {
                                // Loop through the users array and append options
                                response.users.forEach(function(user) {
                                    userSelect.append(new Option(
                                        `${user.name} (${user.email})`,
                                        user.id,
                                        false,
                                        false
                                    ));
                                });
                            } else {
                                userSelect.append(new Option(
                                    'No paid users found',
                                    '',
                                    false,
                                    false
                                )).prop('disabled', true);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching users:', error);
                            userSelect.append(new Option(
                                'Error loading users',
                                '',
                                false,
                                false
                            )).prop('disabled', true);
                        },
                        complete: function() {
                            userSelect.prop('disabled', false);
                        }
                    });
                } else {
                    userSelect.prop('disabled', true);
                }
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            let userSelect = $('#user_id');
            let productSelect = $('#product_id');

            // Restore old values if available
            let oldUserId = "{{ old('user_id', $contract->user_id ?? '') }}";
            let oldProductId = "{{ old('property_id', $contract->property_id ?? '') }}";

            if (oldProductId) {
                productSelect.val(oldProductId).trigger('change');
            }

            // Handle product selection change
            productSelect.on('change', function() {
                const productId = $(this).val();

                // Reset user dropdown
                userSelect.empty().append('<option value="">Select User</option>');

                if (productId) {
                    userSelect.prop('disabled', true);

                    $.ajax({
                        url: "{{ route('fetch.paid.users', ['productId' => ':productId']) }}"
                            .replace(':productId', productId),
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success && response.users.length > 0) {
                                response.users.forEach(function(user) {
                                    let selected = user.id == oldUserId ? 'selected' :
                                        '';
                                    userSelect.append(new Option(
                                        `${user.name} (${user.email})`,
                                        user.id,
                                        false,
                                        selected
                                    ));
                                });
                            } else {
                                userSelect.append(new Option(
                                    'No paid users found',
                                    '',
                                    false,
                                    false
                                )).prop('disabled', true);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching users:', error);
                            userSelect.append(new Option(
                                'Error loading users',
                                '',
                                false,
                                false
                            )).prop('disabled', true);
                        },
                        complete: function() {
                            userSelect.prop('disabled', false);
                        }
                    });
                } else {
                    userSelect.prop('disabled', true);
                }
            });

            // Hide modal if there are errors
            if ($('.is-invalid').length > 0) {
                $('.modal').modal('hide');
            }
        });
    </script>



@endsection
