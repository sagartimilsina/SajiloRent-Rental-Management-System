@extends('frontend.layouts.main')

@section('title', 'Invoice')

@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            margin-bottom: 20px;
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

        .invoice-total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }
    </style>

    <div class="invoice-container mt-5 container container-left">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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
                            <td>NPR {{ number_format($item['property_price'] * $item['property_quantity'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="invoice-total">
            @php

                $taxRate = 0.13; // Example 13% VAT
                $tax = $totalAmount * $taxRate;
                $grandTotal = $totalAmount + $tax;

            @endphp
            <div class="invoice-total">
                <p>Subtotal: NPR {{ number_format($totalAmount, 2) }}</p>
                <p>Tax (13%): NPR {{ number_format($tax, 2) }}</p>
                <p>Total Amount: NPR {{ number_format($grandTotal, 2) }}</p>
            </div>

        </div>
    </div>
@endsection
