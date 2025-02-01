@extends('frontend.layouts.main')
@section('title', 'Checkout')

@section('content')


@section('content')


    {{-- <section class="breadcrumb-hero ">
        <hr>
        <div class="container text-start breadcrumb-overlay" style="padding: 0;">
            <nav class="breadcrumb">
                <a class="breadcrumb-item" href="{{ route('index') }}">Home</a>
                <a class="" href="{{ route('cart.index') }}">Cart</a>


                <a href="#" class="active-nav" aria-current="page">Checkout </a>
            </nav>
        </div>
        <hr>
    </section> --}}
    <div class="container mt-5">
        <div class="row">
            <!-- Order Summary -->
            <!-- Order Summary -->
            <div class="col-md-6">
                <div class="order-summary">
                    <h5>Booking Order Summary</h5>
                    {{-- @foreach ($cartItems as $item)
                        <div class="d-flex justify-content-between align-items-center my-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('storage/' . $item->property->property_image) }}"
                                    alt="{{ $item->property->property_name }}" class="me-3"
                                    style="width: 80px; height: 80px;">
                                <div>
                                    <div>{{ $item->property->property_name }}</div>
                                    <small class="text-muted">{{ $item->property->property_location }}</small>
                                </div>
                            </div>
                            <div>${{ number_format($item->property->property_sell_price, 2) }}</div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-between my-3">
                        <div>SUB-TOTAL</div>
                        <div>${{ number_format($subtotal, 2) }}</div>
                    </div>
                    <div class="d-flex justify-content-between my-3">
                        <div>SHIPPING</div>
                        <div>$20.00</div>
                    </div>
                    <div class="d-flex justify-content-between my-3">
                        <div>TOTAL</div>
                        <div>${{ number_format($total, 2) }}</div>
                    </div> --}}
                    @foreach ($cartItems as $item)
                        <div class="d-flex justify-content-between align-items-center my-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('storage/' . $item->property->property_image) }}"
                                    alt="{{ $item->property->property_name }}" class="me-3"
                                    style="width: 80px; height: 80px;">
                                <div>
                                    <div>{{ $item->property->property_name }}</div>
                                    <small class="text-muted">
                                        {{ $item->property->property_location }}
                                        (Qty: {{ $item->property_quantity }})
                                    </small>
                                </div>
                            </div>
                            <div>
                                <div>
                                    Rs{{ number_format($item->property->property_sell_price * $item->property_quantity, 2) }}
                                </div>
                                <small class="text-muted">Rs {{ number_format($item->property->property_sell_price, 2) }} x
                                    {{ $item->property_quantity }}</small>
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-between my-3">
                        <div>SUB-TOTAL</div>
                        <div>Rs{{ number_format($subtotal, 2) }}</div>
                    </div>

                    <div class="d-flex justify-content-between my-3">
                        <div>TAX</div>
                        <div>Rs{{ number_format($tax, 2) }}</div>
                    </div>

                    <div class="d-flex justify-content-between my-3">
                        <div>TOTAL</div>
                        <div>Rs{{ number_format($subtotal + $tax, 2) }}</div>
                    </div>

                </div>
            </div>

            <!-- Payment Section -->
            <div class="col-md-6">
                <div class="checkout">
                    <h5>Payment Wallet</h5>
                    <div class="payment-options">
                        <div class="row">
                            <!-- eSewa Card -->
                            <div class="col-md-4 mb-3">
                                <form action="{{ route('esewa.payment') }}" method="POST" id="esewaPaymentForm">
                                    @csrf
                                    @foreach ($cartItems as $index => $item)
                                        <input type="hidden" name="cartItems[{{ $index }}][property_id]"
                                            value="{{ $item->property_id }}">
                                        <input type="hidden" name="cartItems[{{ $index }}][property_quantity]"
                                            value="{{ $item->property_quantity }}">
                                        
                                    @endforeach
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">


                                    <input type="hidden" name="amount" value="{{ number_format($subtotal, 2) }}"
                                        required>
                                    <input type="hidden" name="tax_amount" value="{{ number_format($tax, 2) }}" required>
                                    <input type="hidden" name="total_amount"
                                        value="{{ number_format($subtotal + $tax, 2) }}" required>
                                    {{-- <!-- Hidden fields for transaction UUID and product code can be added if needed -->
                                    <input type="hidden" name="transaction_uuid" value="{{ uniqid() }}" required> --}}
                                    <!-- Replace with your UUID generation logic -->
                                    <input type="hidden" name="product_code" value="EPAYTEST" required>
                                    <!-- Replace with your actual product code -->

                                    <!-- eSewa Payment Card -->
                                    <div class="card payment-card text-center" id="esewaCard" style="cursor: pointer;"
                                        onclick="document.getElementById('esewaPaymentForm').submit();">
                                        <img src="https://cdn.esewa.com.np/ui/images/esewa_og.png?111" alt="eSewa"
                                            class="card-img-top p-2"
                                            style="height: 100px; object-fit: contain; margin: auto; display: block;">
                                    </div>
                                </form>

                            </div>

                            <!-- Khalti Card -->
                            <div class="col-md-4 mb-3">
                                <div class="card payment-card text-center" id="khaltiCard" style="cursor: pointer;">
                                    <img src="https://d1yjjnpx0p53s8.cloudfront.net/styles/logo-thumbnail/s3/082018/untitled-1_110.png?NUSEVyMKG.6mmq9Jwutfm3zYrezAp4gA&itok=nwwsDR-M"
                                        alt="Khalti" class="card-img-top p-2"
                                        style="height: 100px; object-fit: contain; margin: auto; display: block;">
                                </div>
                            </div>

                            <!-- Stripe Card -->
                            <div class="col-md-4 mb-3">
                                <div class="card payment-card text-center" id="stripeCard" style="cursor: pointer;">
                                    <img src="https://w7.pngwing.com/pngs/903/316/png-transparent-stripe-payment-gateway-payment-processor-authorize-net-colored-stripes-thumbnail.png"
                                        alt="Stripe" class="card-img-top p-2"
                                        style="height: 100px; object-fit: contain; margin: auto; display: block;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Forms -->
                    <div class="payment-forms mt-4">
                        <!-- Stripe Form -->
                        <div id="stripeForm" class="payment-form d-none">
                            <h5 class="text-center mb-3">Pay with Stripe</h5>
                            <div class="mb-2">
                                <label>Card Holder's Name</label>
                                <input type="text" class="form-control" placeholder="Enter the cardholder's name">
                            </div>
                            <div class="mb-2">
                                <label>Card Number</label>
                                <input type="text" class="form-control" placeholder="Enter the card number">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label>Expiration Date</label>
                                    <input type="text" class="form-control" placeholder="MM/YY">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label>CVV</label>
                                    <input type="text" class="form-control" placeholder="Enter CVV (e.g., 123)">
                                </div>
                            </div>
                            <button class="btn btn-primary w-25" type="submit">
                                Pay with Stripe
                            </button>
                            <button class="btn btn-primary w-25" type="submit">
                                Pay with Stripe
                            </button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const paymentCards = document.querySelectorAll('.payment-card');
            const paymentForms = document.querySelectorAll('.payment-form');

            paymentCards.forEach((card) => {
                card.addEventListener('click', () => {
                    // Hide all payment forms
                    paymentForms.forEach((form) => form.classList.add('d-none'));

                    // Show the selected payment form
                    const formId = card.id.replace('Card', 'Form');
                    document.getElementById(formId).classList.remove('d-none');
                });
            });
        });
    </script>
    <script>
        document.getElementById('esewaCard').addEventListener('click', function() {
            document.getElementById('esewaPaymentForm').submit();
        });
    </script>

@endsection
