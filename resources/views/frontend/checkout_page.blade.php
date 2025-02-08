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
                                    <input type="hidden" name="product_code" value="EPAYTEST" required>
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
                            <!-- Khalti Card -->
                            <div class="col-md-4 mb-3">
                                <form action="{{ route('khalti.initiate') }}" method="POST" id="khaltiPaymentForm">
                                    @csrf
                                    <!-- Cart Items -->
                                    @foreach ($cartItems as $index => $item)
                                        <input type="hidden" name="cartItems[{{ $index }}][property_id]"
                                            value="{{ $item->property_id }}">
                                        <input type="hidden" name="cartItems[{{ $index }}][property_quantity]"
                                            value="{{ $item->property_quantity }}">
                                    @endforeach

                                    <!-- User Info -->
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                                    <!-- Payment Details -->
                                    <input type="hidden" name="amount" value="{{ $subtotal }}">
                                    <!-- Convert to paisa -->
                                    <input type="hidden" name="tax_amount" value="{{ $tax }}">
                                    <input type="hidden" name="total_amount" value="{{ $subtotal + $tax }}">
                                    <input type="hidden" name="purchase_order_name"
                                        value="Order from {{ Auth::user()->name }}">

                                    <!-- Customer Info -->
                                    <input type="hidden" name="customer_info[name]" value="{{ Auth::user()->name }}">
                                    <input type="hidden" name="customer_info[email]" value="{{ Auth::user()->email }}">
                                    <input type="hidden" name="customer_info[phone]" value="{{ Auth::user()->phone }}">

                                    <!-- Amount Breakdown -->
                                    <input type="hidden" name="amount_breakdown[0][label]" value="Subtotal">
                                    <input type="hidden" name="amount_breakdown[0][amount]" value="{{ $subtotal }}">
                                    <input type="hidden" name="amount_breakdown[1][label]" value="VAT">
                                    <input type="hidden" name="amount_breakdown[1][amount]" value="{{ $tax }}">

                                    <!-- Product Details -->
                                    @foreach ($cartItems as $index => $item)
                                        <input type="hidden" name="cartItems[{{ $index }}][property_id]"
                                            value="{{ $item->property_id }}">
                                        <input type="hidden" name="cartItems[{{ $index }}][property_quantity]"
                                            value="{{ $item->property_quantity }}">
                                        <input type="hidden" name="cartItems[{{ $index }}][unit_price]"
                                            value="{{ $item->property->property_sell_price }}">
                                    @endforeach

                                    <!-- Merchant Info -->
                                    <input type="hidden" name="merchant_username"
                                        value="{{ config('services.khalti.merchant_name') }}">
                                    <input type="hidden" name="merchant_extra" value="Property Purchase">

                                    <!-- Khalti Payment Card -->
                                    <div class="card payment-card text-center" id="khaltiCard" style="cursor: pointer;"
                                        onclick="document.getElementById('khaltiPaymentForm').submit();">
                                        <img src="https://d1yjjnpx0p53s8.cloudfront.net/styles/logo-thumbnail/s3/082018/untitled-1_110.png?NUSEVyMKG.6mmq9Jwutfm3zYrezAp4gA&itok=nwwsDR-M"
                                            alt="Khalti" class="card-img-top p-2"
                                            style="height: 100px; object-fit: contain; margin: auto; display: block;">
                                    </div>
                                </form>
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

                    <style>
                        .payment-form label {
                            display: block;
                            text-align: left;
                            margin-bottom: 0.5rem;
                            font-weight: 500;
                        }

                        .payment-form input,
                        .payment-form .StripeElement {
                            width: 100%;
                            padding: 10px;
                            border: 1px solid #ccc;
                            border-radius: 5px;
                            font-size: 16px;
                            transition: all 0.3s ease-in-out;
                        }

                        .payment-form input:focus,
                        .payment-form .StripeElement--focus {
                            border-color: #FF8000;
                            box-shadow: 0 0 5px #ff80007d;
                            outline: none;
                        }

                        .error-message {
                            color: #dc3545;
                            font-size: 0.875rem;
                            margin-top: 0.25rem;
                            text-align: left;
                        }

                        .payment-form .row {
                            display: flex;
                            gap: 15px;
                            margin-bottom: 1rem;
                        }

                        .payment-form .col-md-6 {
                            flex: 1;
                        }

                        #loading-indicator {
                            color: #6c757d;
                            font-size: 0.875rem;
                        }
                    </style>
                    <form id="payment-form" action="{{ route('payment.process.stripe') }}" method="POST">
                        @csrf

                        <div class="card shadow mt-4">
                            <div id="stripeForm" class="payment-form p-3">
                                <h5 class="text-center mb-3">Pay with Stripe</h5>

                                <!-- Card Holder's Name -->
                                <div class="mb-2">
                                    <label for="cardholder-name" class="form-label">Card Holder's Name</label>
                                    <input type="text" id="cardholder-name" name="cardholder_name"
                                        class="form-control" placeholder="Enter the cardholder's name">
                                </div>

                                <!-- Card Number -->
                                <div class="mb-2">
                                    <label class="form-label">Card Number</label>
                                    <div id="card-number" class="form-control"></div>
                                </div>

                                <!-- Expiry Date & CVV -->
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Expiration Date</label>
                                        <div id="card-expiry" class="form-control"></div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">CVV</label>
                                        <div id="card-cvc" class="form-control"></div>
                                    </div>
                                </div>

                                <!-- Error Display -->
                                <div id="card-errors" class="text-danger my-2 p-2"></div>

                                <!-- Hidden Inputs -->
                                <input type="hidden" name="total_amount" value="{{ $total + $tax }}">
                                @foreach ($cartItems as $index => $item)
                                    <input type="hidden" name="cartItems[{{ $index }}][property_id]"
                                        value="{{ $item->property_id }}">
                                    <input type="hidden" name="cartItems[{{ $index }}][property_quantity]"
                                        value="{{ $item->property_quantity }}">
                                @endforeach
                                <input type="hidden" id="payment-method-id" name="payment_method_id">
                                <input type="hidden" name="currency" value="NPR">

                                <!-- Payment Button -->
                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    <button type="submit" id="submit-button" class="btn btn-primary w-50">
                                        Pay with Stripe
                                    </button>
                                </div>

                                <!-- Loading Indicator -->
                                <div id="loading-indicator" class="text-center mt-2 d-none">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Processing...
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.stripe.com/v3/" onerror="alert('Stripe failed to load. Please check your connection.')">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const stripeForm = document.getElementById('stripeForm');
            const stripeCard = document.getElementById('stripeCard');

            // Initially hide the payment form
            stripeForm.style.display = 'none';

            // Show the form when clicking on the Stripe card
            stripeCard.addEventListener('click', () => {
                stripeForm.style.display = 'block';
                stripeCard.style.pointerEvents = 'none'; // Disable further clicks
            });

            // Initialize Stripe
            const stripe = Stripe('{{ config('services.stripe.key') }}');
            const elements = stripe.elements();

            const style = {
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                }
            };

            // Create Stripe elements
            const cardNumber = elements.create('cardNumber', {
                style
            });
            const cardExpiry = elements.create('cardExpiry', {
                style
            });
            const cardCvc = elements.create('cardCvc', {
                style
            });

            cardNumber.mount('#card-number');
            cardExpiry.mount('#card-expiry');
            cardCvc.mount('#card-cvc');

            // Handle Form Submission
            const form = document.getElementById('payment-form');
            const submitButton = document.getElementById('submit-button');
            const loadingIndicator = document.getElementById('loading-indicator');
            const cardholderName = document.getElementById('cardholder-name');
            const paymentMethodInput = document.getElementById('payment-method-id');

            form.addEventListener('submit', async (event) => {
                event.preventDefault();
                submitButton.disabled = true;
                loadingIndicator.classList.remove('d-none');

                try {
                    // Create Stripe Payment Method
                    const {
                        paymentMethod,
                        error
                    } = await stripe.createPaymentMethod({
                        type: 'card',
                        card: cardNumber,
                        billing_details: {
                            name: cardholderName.value.trim()
                        }
                    });

                    if (error) {
                        throw error;
                    }

                    // Set the Payment Method ID in the hidden input and submit the form
                    paymentMethodInput.value = paymentMethod.id;
                    form.submit();
                } catch (error) {
                    document.getElementById('card-errors').textContent = error.message;
                    submitButton.disabled = false;
                    loadingIndicator.classList.add('d-none');
                }
            });
        });
    </script>
    <script>
        document.getElementById('esewaCard').addEventListener('click', function() {
            document.getElementById('esewaPaymentForm').submit();
        });
    </script>
    <script>
        document.getElementById('khaltiCard').addEventListener('click', function() {
            document.getElementById('khaltiPaymentForm').submit();
        });
    </script>

@endsection
