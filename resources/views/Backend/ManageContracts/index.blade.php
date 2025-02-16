@extends('backend.layouts.main')

@section('title', 'Contracts')
@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        {{-- <h4 class="mb-0 text-{{ $statusColor }}">
                            {{ ucfirst($currentStatus) }} Request List
                        </h4> --}}
                        <h4 class="mb-0 text-primary">Contracts</h4>

                        <div class="d-flex flex-wrap align-items-center">




                            <!-- End Search Form -->
                            <a href="{{ route('property-contracts.index') }}" class="btn btn-sm btn-info ms-2 shadow-sm">
                                <i class="bx bx-refresh me-1"></i>
                            </a>
                            <a href="{{ route('property-contracts.index', ['status' => 'pending']) }}"
                                class="btn btn-sm btn-primary ms-2 shadow-sm">
                                <i class="bx bx-hourglass text-white me-1"></i> Pending
                            </a>
                            <a href="{{ route('property-contracts.index', ['status' => 'approved']) }}"
                                class="btn btn-sm btn-success ms-2 shadow-sm">
                                <i class="bx bx-check-circle text-white me-1"></i> Approved
                            </a>
                            <a href="{{ route('property-contracts.index', ['status' => 'rejected']) }}"
                                class="btn btn-sm btn-danger ms-2 shadow-sm">
                                <i class="bx bx-x-circle text-white me-1"></i> Rejected
                            </a>
                            <a href="{{ route('property-contracts.index', ['status' => 'expired']) }}"
                                class="btn btn-sm btn-warning ms-2 shadow-sm">
                                <i class="bx bx-timer text-white me-1"></i> Expired
                            </a>

                            <a href="{{ route('property-contracts.create') }}"
                                class="btn btn-primary btn-sm ms-3 shadow-sm">
                                <i class="bx bx-plus me-1"></i> Add Contract
                            </a>

                        </div>
                    </div>
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary">Contracts</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>User</th>
                                        <th>Property</th>
                                        <th>Type</th>
                                        <th>Contract Date</th>

                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contracts as $contract)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $contract->user->name }}</td>
                                            <td>{{ $contract->property->property_name }}</td>
                                            <td>{{ $contract->contract_type }}</td>
                                            <td>{{ \Carbon\Carbon::parse($contract->contract_start_date)->format('M d, Y') }}
                                                to
                                                {{ \Carbon\Carbon::parse($contract->contract_end_date)->format('M d, Y') }}
                                            </td>

                                            </td>

                                            <td>
                                                <span
                                                    class="badge 
                                                    @if ($contract->contract_status === 'active') bg-success
                                                    @elseif ($contract->contract_status === 'pending') bg-warning
                                                    @elseif ($contract->contract_status === 'approved') bg-primary
                                                    @elseif ($contract->contract_status === 'rejected') bg-danger
                                                    @elseif ($contract->contract_status === 'cancelled') bg-secondary
                                                    @elseif ($contract->contract_status === 'completed') bg-info
                                                    @elseif ($contract->contract_status === 'expired') bg-dark
                                                    @else bg-light @endif">
                                                    {{ ucfirst($contract->contract_status) }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-link p-0 text-secondary"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">





                                                        <li>
                                                            <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $contract->id }}">
                                                                <i class="bx bx-trash me-1 text-danger"></i> Delete
                                                            </button>
                                                        </li>


                                                    </ul>




                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="deleteModal{{ $contract->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="deleteModalLabel{{ $contract->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="deleteModalLabel{{ $contract->id }}">
                                                                        Delete Contract </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete permanently?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form
                                                                        action="{{ route('property-contracts.destroy', $contract->id) }}"
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $contracts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
