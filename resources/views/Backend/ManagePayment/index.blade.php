@extends('backend.layouts.main')

@section('title', 'Payment List')

@section('content')
    <style>
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .invoice-details,
        .invoice-items {
            margin-bottom: 10px;
        }

        .invoice-details table,
        .invoice-items table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-details th,
        .invoice-details td,
        .invoice-items th,
        .invoice-items td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .invoice-details th,
        .invoice-items th {
            background-color: #f5f5f5;
        }

        .invoice-total p {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
        }

        @media print {

            .download-icon,
            #paymentStatusModal {
                display: none;
            }

            .invoice-container {
                width: 100%;
                box-shadow: none;
            }
        }
    </style>
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary">Payment List</h4>
                        <div class="d-flex flex-wrap align-items-center">
                            <form action="{{ route('payments.index') }}" method="GET"
                                class="d-flex align-items-center me-3 mb-2 mb-sm-0">
                                <div class="input-group">
                                    <input type="search" id="search-input" name="search" class="form-control"
                                        placeholder="Search by transaction code..." aria-label="Search"
                                        value="{{ request('search') }}">
                                </div>
                                <div class="input-group mx-3">
                                    <select name="payment_method" class="form-control">
                                        <option value="">Select Payment Method</option>
                                        <option value="ESEWA" {{ request('payment_method') == 'ESEWA' ? 'selected' : '' }}>
                                            ESEWA</option>
                                        <option value="KHALTI"
                                            {{ request('payment_method') == 'KHALTI' ? 'selected' : '' }}>KHALTI</option>
                                        <option value="STRIPE"
                                            {{ request('payment_method') == 'STRIPE' ? 'selected' : '' }}>STRIPE</option>
                                    </select>
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </div>
                            </form>
                            <a href="{{ route('payments.index') }}" class="btn btn-sm btn-info ms-2 shadow-sm">
                                <i class="bx bx-refresh me-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
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
                                <tbody>
                                    @foreach ($propertyPayments as $payments)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            {{-- <td>{{ $payments->user->name }}</td> --}}
                                            <td>{{ $payments->transaction_code }}</td>
                                            <td>{{ $payments->payment_date }}</td>
                                            <td>{{ $payments->payment_method }}</td>
                                            <td>
                                                @php
                                                    $statusClasses = [
                                                        'PENDING' => 'bg-warning text-dark',
                                                        'COMPLETE' => 'bg-success text-white',
                                                        'FULL_REFUND' => 'bg-danger text-white',
                                                        'PARTIAL_REFUND' => 'bg-info text-white',
                                                        'CANCELLED' => 'bg-secondary text-white',
                                                    ];
                                                    $badgeClass =
                                                        $statusClasses[$payments->status] ?? 'bg-secondary text-white';
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">
                                                    {{ strtoupper(str_replace('_', ' ', $payments->status)) }}
                                                </span>
                                            </td>
                                            <td>NPR {{ number_format($payments->total_amount, 2) }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info view-invoice"
                                                    data-transaction="{{ $payments->transaction_uuid }}"
                                                    data-bs-toggle="modal" data-bs-target="#invoiceModal">
                                                    <i class="bx bx-show me-1"></i> View Invoice
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Modal -->
    <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invoiceModalLabel">Invoice Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="invoice-content" class="text-center">
                        <p class="text-muted">Loading...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printInvoice()">Print Invoice</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include html2canvas and jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    @if (Auth::check() && Auth::user()->role->role_name == 'Super Admin')
        <script>
            function printInvoice() {
                const invoiceContainer = document.querySelector('.invoice-container');

                html2canvas(invoiceContainer, {
                    scale: 2
                }).then((canvas) => {
                    const imgData = canvas.toDataURL('image/png');

                    const {
                        jsPDF
                    } = window.jspdf;
                    const pdf = new jsPDF('p', 'mm', 'a4');

                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = pdf.internal.pageSize.getHeight();
                    const imgWidth = pdfWidth;
                    const imgHeight = (canvas.height * imgWidth) / canvas.width;

                    let position = 0;

                    if (imgHeight <= pdfHeight) {
                        pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    } else {
                        while (position < imgHeight) {
                            pdf.addImage(imgData, 'PNG', 0, position - (position > 0 ? pdfHeight : 0), imgWidth,
                                imgHeight);
                            position += pdfHeight;
                            if (position < imgHeight) pdf.addPage();
                        }
                    }

                    pdf.save('invoice.pdf');
                });
            }

            $(document).ready(function() {
                $(".view-invoice").on("click", function() {
                    let transactionUuid = $(this).data("transaction");
                    $("#invoice-content").html('<p class="text-muted">Loading...</p>');

                    $.ajax({
                        url: `{{ route('superadmin.payment.invoice', ':transactionUuid') }}`.replace(
                            ':transactionUuid', transactionUuid),
                        method: "GET",
                        dataType: "json",
                        success: function(response) {
                            if (response.error) {
                                $("#invoice-content").html(
                                    `<p class="text-danger">${response.error}</p>`);
                            } else {
                                // Build the items HTML dynamically
                                let itemsHTML = '';
                                response.cartItems.forEach(item => {
                                    itemsHTML += `
                            <tr>
                                <td>${item.property_name}</td>
                                <td>${item.property_quantity}</td>
                                <td>NPR ${item.property_price}</td>
                                <td>NPR ${item.property_price * item.property_quantity}</td>
                            </tr>`;
                                });

                                // Calculate subtotal and tax
                                let subtotal = (response.totalAmount / 1.13).toFixed(2);
                                let tax = (response.totalAmount - subtotal).toFixed(2);

                                // Build the invoice HTML
                                let invoiceHtml = `
                        <div class="invoice-container">
                            <div class="invoice-header">
                                <h1>Invoice</h1>
                                <p>Thank you for your purchase! Your invoice details are as follows:</p>
                            </div>
                            <div class="invoice-details">
                                <table>
                                    <tr>
                                        <th>Name</th>
                                        <td>${response.user.name}</td>
                                    </tr>
                                     <tr>
                                        <th>Email</th>
                                        <td>${response.user.email}</td>
                                    </tr>
                                     <tr>
                                        <th>Phone</th>
                                        <td>${response.user.phone || 'N/A'}</td>
                                    </tr>
                                    <tr>
                                        <th>Invoice Number</th>
                                        <td>${response.transactionUuid}</td>
                                    </tr>
                                    <tr>
                                        <th>Transaction Code</th>
                                        <td>${response.transactionCode}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Date</th>
                                        <td>${response.paymentDate}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Method</th>
                                        <td>${response.paymentMethod}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>${response.status}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="invoice-items">
                              
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${itemsHTML}
                                    </tbody>
                                </table>
                            </div>
                            <div class="invoice-total">
                               
                                <p>Sub Total: NPR ${subtotal}</p>
                                <p>Tax (13%): NPR ${tax}</p>
                                <p class="fw-bold">Total Amount: NPR ${response.totalAmount.toFixed(2)}</p>
                            </div>
                        </div>`;

                                $("#invoice-content").html(invoiceHtml);
                            }
                        },
                        error: function() {
                            $("#invoice-content").html(
                                '<p class="text-danger">Error loading invoice.</p>');
                        }
                    });
                });
            });
        </script>
    @elseif(Auth::check() && Auth::user()->role->role_name == 'Admin')
        <script>
            function printInvoice() {
                const invoiceContainer = document.querySelector('.invoice-container');

                html2canvas(invoiceContainer, {
                    scale: 2
                }).then((canvas) => {
                    const imgData = canvas.toDataURL('image/png');

                    const {
                        jsPDF
                    } = window.jspdf;
                    const pdf = new jsPDF('p', 'mm', 'a4');

                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = pdf.internal.pageSize.getHeight();
                    const imgWidth = pdfWidth;
                    const imgHeight = (canvas.height * imgWidth) / canvas.width;

                    let position = 0;

                    if (imgHeight <= pdfHeight) {
                        pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    } else {
                        while (position < imgHeight) {
                            pdf.addImage(imgData, 'PNG', 0, position - (position > 0 ? pdfHeight : 0), imgWidth,
                                imgHeight);
                            position += pdfHeight;
                            if (position < imgHeight) pdf.addPage();
                        }
                    }

                    pdf.save('invoice.pdf');
                });
            }

            $(document).ready(function() {
                $(".view-invoice").on("click", function() {
                    let transactionUuid = $(this).data("transaction");
                    $("#invoice-content").html('<p class="text-muted">Loading...</p>');

                    $.ajax({
                        url: `{{ route('payment.invoice', ':transactionUuid') }}`.replace(
                            ':transactionUuid', transactionUuid),
                        method: "GET",
                        dataType: "json",
                        success: function(response) {
                            if (response.error) {
                                $("#invoice-content").html(
                                    `<p class="text-danger">${response.error}</p>`);
                            } else {
                                // Build the items HTML dynamically
                                let itemsHTML = '';
                                response.cartItems.forEach(item => {
                                    itemsHTML += `
                            <tr>
                                <td>${item.property_name}</td>
                                <td>${item.property_quantity}</td>
                                <td>NPR ${item.property_price}</td>
                                <td>NPR ${item.property_price * item.property_quantity}</td>
                            </tr>`;
                                });

                                // Calculate subtotal and tax
                                let subtotal = (response.totalAmount / 1.13).toFixed(2);
                                let tax = (response.totalAmount - subtotal).toFixed(2);

                                // Build the invoice HTML
                                let invoiceHtml = `
                        <div class="invoice-container">
                            <div class="invoice-header">
                                <h1>Invoice</h1>
                                <p>Thank you for your purchase! Your invoice details are as follows:</p>
                            </div>
                            <div class="invoice-details">
                                <table>
                                    <tr>
                                        <th>Name</th>
                                        <td>${response.user.name}</td>
                                    </tr>
                                     <tr>
                                        <th>Email</th>
                                        <td>${response.user.email}</td>
                                    </tr>
                                     <tr>
                                        <th>Phone</th>
                                        <td>${response.user.phone || 'N/A'}</td>
                                    </tr>
                                    <tr>
                                        <th>Invoice Number</th>
                                        <td>${response.transactionUuid}</td>
                                    </tr>
                                    <tr>
                                        <th>Transaction Code</th>
                                        <td>${response.transactionCode}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Date</th>
                                        <td>${response.paymentDate}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Method</th>
                                        <td>${response.paymentMethod}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>${response.status}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="invoice-items">
                              
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${itemsHTML}
                                    </tbody>
                                </table>
                            </div>
                            <div class="invoice-total">
                               
                                <p>Sub Total: NPR ${subtotal}</p>
                                <p>Tax (13%): NPR ${tax}</p>
                                <p class="fw-bold">Total Amount: NPR ${response.totalAmount.toFixed(2)}</p>
                            </div>
                        </div>`;

                                $("#invoice-content").html(invoiceHtml);
                            }
                        },
                        error: function() {
                            $("#invoice-content").html(
                                '<p class="text-danger">Error loading invoice.</p>');
                        }
                    });
                });
            });
        </script>
    @endif
@endsection
