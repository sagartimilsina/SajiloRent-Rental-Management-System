@extends('frontend.layouts.main')
@section('title', 'Checkout')
`

<section class="breadcrumb-hero ">
    <hr>
    <div class="container text-start breadcrumb-overlay" style="padding: 0;">
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ route('index') }}">Home</a>
            <a class="" href="cart.html">Cart</a>


            <a href="#" class="active-nav" aria-current="page">Checkout </a>
        </nav>
    </div>
    <hr>
</section>
<div class="container mt-3">
    <div class="row">
        <!-- Order Summary -->
        <div class="col-md-6 ">
            <div class="order-summary">
                <h5>Order Summary</h5>
                <div class="d-flex justify-content-between align-items-center my-3">
                    <div class="d-flex align-items-center">
                        <img src="https://placehold.co/80x80" alt="Wireless Headphones" class="me-3">
                        <div>
                            <div>XB950B1 EXTRA BASS™ Wireless Headphones</div>
                            <small class="text-muted">MDR-XB950B1</small>
                        </div>
                    </div>
                    <div>$399.99</div>
                </div>
                <div class="d-flex justify-content-between align-items-center my-3">
                    <div class="d-flex align-items-center">
                        <img src="https://placehold.co/80x80" alt="Red Backpack" class="me-3">
                        <div>
                            <div>Supreme Louis Vuitton Backpack</div>
                            <small class="text-muted">Red</small>
                        </div>
                    </div>
                    <div>$157.99</div>
                </div>
                <div class="d-flex justify-content-between align-items-center my-3">
                    <div class="d-flex align-items-center">
                        <img src="https://placehold.co/80x80" alt="Blue Volt Shoes" class="me-3">
                        <div>
                            <div>Armory Navy Gamma Blue Volt</div>
                            <small class="text-muted">Nike Air Max 2013</small>
                        </div>
                    </div>
                    <div>$115.98</div>
                </div>
                <div class="d-flex justify-content-between my-3">
                    <div>SUB-TOTAL</div>
                    <div>$673.96</div>
                </div>
                <div class="d-flex justify-content-between my-3">
                    <div>SHIPPING</div>
                    <div>$20.00</div>
                </div>
                <div class="d-flex justify-content-between my-3">
                    <div>TOTAL</div>
                    <div>$693.96</div>
                </div>
            </div>
        </div>

        <!-- Payment Section -->
        <div class="col-md-6 ">
            <div class="checkout">
                <h5>Checkout</h5>
                <div class="accordion" id="paymentAccordion">
                    <!-- Esewa -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="esewaHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#esewaCollapse" aria-expanded="false" aria-controls="esewaCollapse">
                                <img src="https://cdn.esewa.com.np/ui/images/esewa_og.png?111" alt="eSewa"
                                    style="margin-right: 10px; object-fit: cover;" width="50" height="30" />
                                eSewa
                            </button>
                        </h2>
                        <div id="esewaCollapse" class="accordion-collapse collapse" aria-labelledby="esewaHeading"
                            data-bs-parent="#paymentAccordion">
                            <div class="accordion-body">
                                <h5 class="text-center mb-3">Pay with eSewa</h5>
                                <div class="mb-2">
                                    <input type="text" class="form-control" id="esewaName"
                                        placeholder="Enter your Name">
                                </div>
                                <div class="mb-2">
                                    <input type="email" class="form-control" id="esewaEmail"
                                        placeholder="Enter your Email">
                                </div>
                                <div class="mb-2">
                                    <input type="tel" class="form-control" id="esewaPhone"
                                        placeholder="Enter your Phone Number">
                                </div>
                                <button class="btn btn-success w-100">Pay with eSewa</button>
                            </div>
                        </div>
                    </div>

                    <!-- Khalti -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="khaltiHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#khaltiCollapse" aria-expanded="false" aria-controls="khaltiCollapse">
                                <img src="https://d1yjjnpx0p53s8.cloudfront.net/styles/logo-thumbnail/s3/082018/untitled-1_110.png?NUSEVyMKG.6mmq9Jwutfm3zYrezAp4gA&itok=nwwsDR-M"
                                    alt="Khalti" style="margin-right: 10px; object-fit: cover;" width="50"
                                    height="30" />
                                Khalti
                            </button>
                        </h2>
                        <div id="khaltiCollapse" class="accordion-collapse collapse" aria-labelledby="khaltiHeading"
                            data-bs-parent="#paymentAccordion">
                            <div class="accordion-body">
                                <h5 class="text-center mb-3">Pay with Khalti</h5>
                                <div class="mb-2">
                                    <input type="text" class="form-control" id="khaltiName"
                                        placeholder="Enter your Name">
                                </div>
                                <div class="mb-2">
                                    <input type="email" class="form-control" id="khaltiEmail"
                                        placeholder="Enter your Email">
                                </div>
                                <div class="mb-2">
                                    <input type="tel" class="form-control" id="khaltiPhone"
                                        placeholder="Enter your Phone Number">
                                </div>
                                <button class="btn btn-primary w-100">Pay with Khalti</button>
                            </div>
                        </div>
                    </div>

                    <!-- Stripe -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="stripeHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#stripeCollapse" aria-expanded="false"
                                aria-controls="stripeCollapse">
                                <img src="https://w7.pngwing.com/pngs/903/316/png-transparent-stripe-payment-gateway-payment-processor-authorize-net-colored-stripes-thumbnail.png"
                                    alt="Stripe" style="margin-right: 10px; object-fit: cover;" width="50"
                                    height="30" />
                                Stripe
                            </button>
                        </h2>
                        <div id="stripeCollapse" class="accordion-collapse collapse" aria-labelledby="stripeHeading"
                            data-bs-parent="#paymentAccordion">
                            <div class="accordion-body">
                                <h5 class="text-center mb-3">Pay with Stripe</h5>
                                <div class="mb-2">
                                    <label for="cardHolderName" class="text-start d-block">Card Holder's Name</label>
                                    <input type="text" class="form-control" id="cardHolderName"
                                        placeholder="Enter the cardholder's name">
                                </div>
                                <div class="mb-2">
                                    <label for="cardNumber" class="text-start d-block">Card Number</label>
                                    <input type="text" class="form-control" id="cardNumber"
                                        placeholder="Enter the card number">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="expirationDate" class="text-start d-block">Expiration Date</label>
                                        <input type="text" class="form-control" id="expirationDate"
                                            placeholder="MM/YY">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="cvv" class="text-start d-block">CVV</label>
                                        <input type="text" class="form-control" id="cvv"
                                            placeholder="Enter CVV (e.g., 123)">
                                    </div>
                                </div>
                                <button class="btn btn-danger w-100">Pay with Stripe</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
