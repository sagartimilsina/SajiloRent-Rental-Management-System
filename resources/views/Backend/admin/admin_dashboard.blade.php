@extends('backend.layouts.main')
@section('title', 'Dashboard')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 flex-wrap">
                <div class="card">
                    <!-- Welcome Card -->
                    <div class="card-body">
                        <h5 class="card-title text-primary">Welcome, {{ Auth::user()->name }}! 🎉</h5>
                        <p class="card-text">Here's an overview of your activities and statistics.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Congratulations Card -->
            <div class="col-lg-6 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-6">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Congratulations {{ Auth::user()->name }}! 🎉</h5>
                                <p class="card-text">You have created:</p>
                                <ul>
                                    <li>{{ $total_categories_created_by_you }} Categories</li>
                                    <li>{{ $total_subcategories_created_by_you }} Subcategories</li>
                                    <li>{{ $total_product_created_by_you }} Products</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="/sneat_backend/assets/img/illustrations/man-with-laptop-light.png" height="140"
                                    alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Enrollment Chart -->
            <div class="col-lg-6 mb-4 order-0">
                <div class="card p-2">
                    <canvas id="userEnrollmentChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 order-3 order-md-2">

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Today's Payments</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>User</th>
                                        <th>Property Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th> Total Price</th>
                                        <th>Tax</th>
                                        <th>Total Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($todayPaymentList as $transactionCode => $payments)
                                        @foreach ($payments as $index => $item)
                                            <tr>
                                                @if ($index === 0)
                                                    <!-- Transaction ID and User (display only once per transaction) -->
                                                    <td rowspan="{{ count($payments) }}">{{ $item->transaction_code }}</td>
                                                    <td rowspan="{{ count($payments) }}">{{ $item->user->name }}</td>
                                                @endif
                                                @php
                                                    $tax_amount = $item->total_amount - $item->total_amount / 1.13;
                                                    $subtotal = $item->total_amount - $tax_amount;
                                                @endphp

                                                <!-- Property Details -->
                                                <td>{{ $item->property->property_name }}</td>
                                                <td>{{ $item->property_quantity }}</td>
                                                <td>{{ number_format($item->property->property_sell_price, 2) }}</td>
                                                <td>{{ number_format($item->property->property_sell_price * $item->property_quantity, 2) }}
                                                </td>


                                                <!-- Assuming tax is stored in the payment record -->
                                                @if ($index === 0)
                                                    <td>{{ number_format($tax_amount, 2) }}</td>
                                                    <td>{{ number_format($item->total_amount, 2) }}</td>
                                                    <!-- Date (display only once per transaction) -->
                                                    <td rowspan="{{ count($payments) }}">
                                                        {{ $item->created_at->format('Y-m-d H:i:s') }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No payments found for today.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Total Interacted Users Card -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="bx bx-user" style="font-size: 2rem; color: #4CAF50;"></i>
                                    </div>
                                    <h3 class="card-title mb-1 text-danger">{{ $totalUsersInteracted }}</h3>
                                </div>
                                <span class="fw-medium d-block mb-1 text-center text-primary">Total Interacted Users</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="fas fa-rupee-sign" style="font-size: 2rem; color: #FFA500;"></i>

                                    </div>
                                    <h3 class="card-title mb-1 text-danger">{{ number_format($todayPaymentAmount, 2) }}
                                    </h3>
                                </div>
                                <span class="fw-medium d-block mb-1 text-center text-primary">Today Payments</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Payment Amount Card -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="fas fa-rupee-sign" style="font-size: 2rem; color: #FFA500;"></i>

                                    </div>
                                    <h3 class="card-title mb-1 text-danger">{{ number_format($totalPaymentAmount, 2) }}
                                    </h3>
                                </div>
                                <span class="fw-medium d-block mb-1 text-center text-primary">Total Payments</span>
                            </div>
                        </div>
                    </div>

                    <!-- Daily Enrollments Card -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="bx bx-calendar" style="font-size: 2rem; color: #007BFF;"></i>
                                    </div>
                                    <h3 class="card-title mb-1 text-danger">{{ $dailyEnrollments }}</h3>
                                </div>
                                <span class="fw-medium d-block mb-1 text-center text-primary">Daily Enrollments</span>
                            </div>
                        </div>
                    </div>

                    <!-- New Messages Card -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="bx bx-message" style="font-size: 2rem; color: #6F42C1;"></i>
                                    </div>
                                    <h3 class="card-title mb-1 text-danger">{{ $newMessages }}</h3>
                                </div>
                                <span class="fw-medium d-block mb-1 text-center text-primary">New Messages</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Statistics -->
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-center justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-calendar-week" style="font-size: 2rem; color: #28A745;"></i>
                            </div>
                            <h3 class="card-title mb-1 text-danger">{{ $weeklyEnrollments }}</h3>
                        </div>
                        <span class="fw-medium d-block mb-1 text-center text-primary">Weekly Enrollments</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-center justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-calendar" style="font-size: 2rem; color: #DC3545;"></i>
                            </div>
                            <h3 class="card-title mb-1 text-danger">{{ $monthlyEnrollments }}</h3>
                        </div>
                        <span class="fw-medium d-block mb-1 text-center text-primary">Monthly Enrollments</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-center justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-calendar" style="font-size: 2rem; color: #17A2B8;"></i>
                            </div>
                            <h3 class="card-title mb-1 text-danger">{{ $yearlyEnrollments }}</h3>
                        </div>
                        <span class="fw-medium d-block mb-1 text-center text-primary">Yearly Enrollments</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-center justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-star" style="font-size: 2rem; color: #FFC107;"></i>
                            </div>
                            <h3 class="card-title mb-1 text-danger">{{ $newReviews }}</h3>
                        </div>
                        <span class="fw-medium d-block mb-1 text-center text-primary">New Reviews</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Get data passed from the controller
        const labels = {!! json_encode(['Daily', 'Weekly', 'Monthly', 'Yearly']) !!};


        const data = {!! json_encode([
            $dailyEnrollments ?? 0,
            $weeklyEnrollments ?? 0,
            $monthlyEnrollments ?? 0,
            $yearlyEnrollments ?? 0,
        ]) !!};


        // Create the chart
        const ctx = document.getElementById('userEnrollmentChart').getContext('2d');
        const userEnrollmentChart = new Chart(ctx, {
            type: 'line', // Line chart type
            data: {
                labels: labels, // X-axis labels
                datasets: [{
                    label: 'User Enrollments', // Chart label
                    data: data, // Y-axis data
                    borderColor: 'rgba(75, 192, 192, 1)', // Line color
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Fill color
                    borderWidth: 5,
                    tension: 0.3, // Smoothing for the line
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true, // Show legend
                    },
                    tooltip: {
                        enabled: true, // Enable tooltips
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Time Period'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Number of Users'
                        },
                        beginAtZero: true // Start Y-axis at zero
                    }
                }
            }
        });
    </script>

@endsection
