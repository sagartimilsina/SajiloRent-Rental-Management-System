@extends('frontend.layouts.main')

@section('title', 'Payment Successful')

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
    <div class="container mt-5 mb-5 d-flex justify-content-center">
        <div class="card shadow p-5 text-center" style="max-width: 500px;">
            <div>
                <img src="{{ asset('frontend/assets/images/success.png') }}" alt="Payment Successful" class="img-fluid mb-1"
                    style="max-height: 200px;">
            </div>
            <div class="text-center pt-1 p-3">
                <h1 class="text-success">Payment Successful</h1>
                <p class="text-muted">Thank you! Your payment was processed successfully.</p>
                <a href="{{ route('index') }}" class="btn btn-outline-primary mt-3 ">Go to Home</a>
                <button type="button" class="btn btn-outline-primary mt-3" data-bs-toggle="modal"
                    data-bs-target="#successModal">
                    View Invoice
                </button>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Invoice Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="invoice-container">
                        <div class="invoice-header">
                            <h1>Invoice</h1>
                            <p>Thank you for your purchase! Your invoice details are as follows:</p>
                        </div>

                        <div class="invoice-details">
                            <table>
                                <tr>
                                    <th>Invoice Number</th>
                                    <td>{{ $transactionUuid }}</td>
                                </tr>
                                <tr>
                                    <th>Transaction Code</th>
                                    <td>{{ $transactionCode }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Date</th>
                                    <td>{{ $paymentDate }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Method</th>
                                    <td>{{ $paymentMethod }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $status }}</td>
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
                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td>{{ $item['property_name'] }}</td>
                                            <td>{{ $item['property_quantity'] }}</td>
                                            <td>NPR {{ number_format($item['property_price'], 2) }}</td>
                                            <td>NPR
                                                {{ number_format($item['property_price'] * $item['property_quantity'], 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="invoice-total">
                            @php
                                $tax_amount = $totalAmount - $totalAmount / 1.13;
                                $subtotal = $totalAmount - $tax_amount;
                            @endphp
                            <p>Sub Total: NPR {{ number_format($subtotal, 2) }}</p>
                            <p>Tax (13%): NPR {{ number_format($tax_amount, 2) }}</p>
                            <p class="fw-bold">Total Amount: NPR {{ number_format($totalAmount, 2) }}</p>
                        </div>
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
    </script>
@endsection
