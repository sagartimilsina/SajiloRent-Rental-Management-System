@extends('frontend.layouts.main')
@section('title', 'Product Details')
@section('content')
    @if (!Auth::check())
        @php
            session()->put('redirectUrl', url()->current());
        @endphp
    @endif
    <main>
        {{-- <section class="breadcrumb-hero ">
            <hr>
            <div class="container text-start breadcrumb-overlay" style="padding: 0;">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="{{ route('index') }}">Home</a>
                    <a class="" href="{{ route('product', ['categoryId' => '1', 'subcategoryId' => '1']) }}">Product</a>
                    <a class="breadcrumb-item" href="{{ route('index') }}">Home</a>
                    <a class="" href="{{ route('product', ['categoryId' => '1', 'subcategoryId' => '1']) }}">Product</a>

                    <a href="#" class="active-nav" aria-current="page">{{ $property->property_name }}</a>
                    <a href="#" class="active-nav" aria-current="page">{{ $property->property_name }}</a>
                </nav>
            </div>
            <hr>
        </section> --}}

        <section class="container container-left mt-4">

            <div class="row">
                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-12">

                    <div class="image-pic">
                        <!-- Main Image -->
                        <img id="mainImage" alt="Main image of the family apartment" class="img-fluid w-100" height="auto"
                            src="{{ asset('storage/' . $property->property_image) }}" />
                        <!-- Thumbnails Carousel -->
                        <div class="img-lists owl-carousel owl-theme mt-2">
                            @foreach ($property->propertyImages as $image)
                                <div class="item">
                                    <img alt="Thumbnail image" class="thumbnail img-fluid" height="400"
                                        src="{{ asset('storage/' . $image->property_image) }}" width="400"
                                        onclick="changeMainImage(this)" />
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="data">
                        <h2 class="mt-3" style="color: #f39c12;">
                            {{ $property->property_name }}
                        </h2>

                        <p>
                            Normal Price: {{ $property->property_price }}
                        </p>
                        <p>
                            Discount Price: {{ $property->property_discount }}
                        </p>
                        <p>
                            Negotiable Price: {{ $property->property_sell_price }}
                        </p>



                    </div>
                    <p>{!! $property->property_description !!}</p>
                    @if ($property->map_link != null)
                        <div class="map-section ">
                            <iframe src="{{ $property->map_link }}" width="100%" height="400" style="border:0;"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                        </div>
                    @endif


                    <!-- Review Section -->
                    <div class="review mt-5">
                        <!-- Submit a Review -->
                        <h4 class="mt-5">Leave a Review</h4>
                        <form action="{{ route('property.review.store', $property->id) }}" method="POST">
                            @csrf

                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                            <style>
                                .star {
                                    font-size: 24px;
                                    color: gray;
                                    cursor: pointer;
                                    transition: color 0.2s;
                                }

                                .star.selected {
                                    color: gold;
                                }
                            </style>

                            <div class="mb-3 mt-2">
                                <label for="rating" class="form-label">Rate the Property</label>
                                <div id="star-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star star" data-value="{{ $i }}"></i>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating" value="">
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label">Comment</label>
                                <textarea name="comment" id="comment" class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}"
                                    rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Submit Review</button>
                        </form>


                        <!-- Existing Reviews -->
                        <div id="reviews-list" class="mt-3">
                            <h5 class="mb-4">Reviews</h5>

                            @forelse ($property_review as $review)
                                <div class="review-item mb-4 card p-4 shadow">
                                    <div class="d-flex justify-content-between align-items-center p-3 pb-1">
                                        <strong>{{ $review->user->name }}</strong>
                                        <div class="ms-3 text-muted">{{ $review->created_at->format('d M, Y') }}</div>
                                    </div>
                                    <div class="rating mb-1 d-flex p-3">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="fas fa-star {{ $i <= $review->property_rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="px-3">{{ $review->property_review }}</p>
                                </div>
                            @empty
                                <p class="px-3">No reviews yet. Be the first to leave a review!</p>
                            @endforelse
                        </div>
                    </div>
                </div>


                <div class="col-md-5 col-xl-4 col-lg-5 col-sm-12">


                    <div class="booking-form">
                        <div class="card shadow">
                            <div class="d-flex gap-3 m-3 flex-row favorite-link align-items-center justify-content-between">

                                @if (Auth::check())
                                    <a href="javascript:void(0);"
                                        class="favorite-link {{ in_array($property->id, $favoriteIds) ? 'text-warning' : 'text-warning' }} "
                                        onclick="toggleFavorite({{ Auth::id() }}, {{ $property->id }})"
                                        title="Add to Favorites">
                                        <i
                                            class="{{ in_array($property->id, $favoriteIds) ? 'fas fa-heart' : 'far fa-heart' }} fa-lg"></i>
                                    </a>
                                @elseif(!Auth::check())
                                    <a href="{{ route('login') }}"
                                        class="favorite-link {{ in_array($property->id, $favoriteIds) ? 'text-warning' : 'text-warning' }} "
                                        title="Add to Favorites">
                                        <i
                                            class="{{ in_array($property->id, $favoriteIds) ? 'fas fa-heart' : 'far fa-heart' }} fa-lg"></i>
                                    </a>
                                @endif




                                <!-- Add to Cart -->
                                <form action="{{ route('cart.add') }}" method="POST" style="display: inline;"
                                    class="cart-add">
                                    @csrf
                                    <input type="hidden" name="property_id" value="{{ $property->id }}">
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <button type="submit" class="btn btn-link text-primary p-0" title="Add to Cart">
                                        <i class="fas fa-shopping-cart me-1 fa-lg"></i>
                                    </button>
                                </form>

                                <!-- Chatbox -->
                                <a href="javascript:void(0);" class="text-info" onclick="openChatbox({{ $property->id }})"
                                    title="Chat">
                                    <i class="fas fa-comments me-1 fa-lg"></i>
                                </a>

                                <!-- Share Property Link -->
                                <a href="javascript:void(0);" class="text-warning "
                                    onclick="shareProperty('{{ route('property.details', ['id' => $property->id]) }}')"
                                    style="position: relative;" title="Share this property">
                                    <i class="fas fa-share-alt fa-lg"></i>
                                </a>

                            </div>

                        </div>

                        <div class="form mt-4">
                            <h5 class="text-uppercase text-center fw-bold-5">Contact Us About This Property</h5>

                            <form method="POST" action="{{ route('property.message.store', $property->id) }}">
                                @csrf
                                <input type="hidden" name="property_id" value="{{ $property->id }}">
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <div class="mb-3">
                                    <label class="form-label" for="fullName">Full Name</label>
                                    <input class="form-control @error('full_name') is-invalid @enderror" id="fullName"
                                        name="full_name" placeholder="Full name" type="text"
                                        value="{{ old('full_name', @Auth::user()->name) }}" readonly />
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="phoneNumber">Phone Number</label>
                                    <input class="form-control @error('phone_number') is-invalid @enderror"
                                        id="phoneNumber" name="phone_number" placeholder="Enter your phone number"
                                        type="text" value="{{ old('phone_number', @Auth::user()->phone) }}" />
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="emailAddress">Email Address</label>
                                    <input class="form-control @error('email_address') is-invalid @enderror"
                                        id="emailAddress" name="email_address" placeholder="example@domain.com"
                                        type="email" value="{{ old('email_address', @Auth::user()->email) }}"
                                        readonly />
                                    @error('email_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="familyMember">Subject</label>
                                    <input class="form-control @error('subject') is-invalid @enderror" id="familyMember"
                                        name="subject" placeholder="Subject" type="text"
                                        value="{{ old('subject') }}" />
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="yourMessage">Your Message</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" id="yourMessage" name="message"
                                        placeholder="Message" rows="3">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button class="btn btn-primary w-100" type="submit">
                                    Send Message
                                </button>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </section>




        <section class="rent-property mt-5">
            <div class="container">
                <!-- Header -->
                <div class="header mb-5 text-center">
                    <h1> Related &amp; Property or Product</h1>

                </div>

                <!-- Navigation Tabs -->
                <div class="container">

                    @if (@$similar_properties->count() > 0)
                        <div class="row justify-content-center">
                            @foreach ($similar_properties as $apartment)
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <a href="{{ route('property.details', ['id' => $apartment->id]) }}"
                                            class="text-decoration-none">
                                            <img alt="{{ $apartment->property_name }}" class="card-img-top img-fluid"
                                                src="{{ asset('storage/' . $apartment->property_image) }}" />

                                            <div class="card-body">
                                                <h5 class="card-title text-truncate">
                                                    {{ $apartment->property_name }}
                                                </h5>
                                                <p class="card-text text-justify">
                                                    {!! \Illuminate\Support\Str::limit(strip_tags($apartment->property_description), 70, '...') !!}
                                                </p>


                                                <p class="card-text small text-muted">
                                                    <i class="fas fa-map-marker-alt me-1"></i>
                                                    {{ $apartment->property_location }}
                                                </p>
                                                <div class="price mt-2">
                                                    <p
                                                        class="text-center d-flex align-items-center justify-content-between">
                                                        <del class="text-danger small">Rs.
                                                            {{ $apartment->property_price }}</del>

                                                        Rs. {{ $apartment->property_sell_price }}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                        <div
                                            class="card-footer bg-white border-0 d-flex justify-content-between align-items-center favorite-link">
                                            <!-- Share Button -->
                                            <a href="javascript:void(0);" class="text-warning"
                                                onclick="shareProperty('{{ route('property.details', ['id' => $apartment->id]) }}')"
                                                style="position: relative;" title="Share this property">
                                                <i class="fas fa-share-alt fa-lg"></i>
                                            </a>
                                            <!-- Add to Favorites Link -->
                                            <a href="javascript:void(0);"
                                                class="favorite-link {{ in_array($apartment->id, $favoriteIds) ? 'text-warning' : 'text-warning' }} "
                                                onclick="toggleFavorite({{ Auth::id() }}, {{ $apartment->id }})"
                                                title="Add to Favorites">
                                                <i
                                                    class="{{ in_array($apartment->id, $favoriteIds) ? 'fas fa-heart' : 'far fa-heart' }} fa-lg"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="text-center mb-4">
                                <a href="{{ route('product_or_property') }}"> <button class="btn btn-primary">View
                                        All</button></a>
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <h3>No Similar Properties Found</h3>
                        </div>
                    @endif

                </div>


            </div>
        </section>


    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const stars = document.querySelectorAll("#star-rating .star");
            const ratingInput = document.getElementById("rating");

            stars.forEach(star => {
                star.addEventListener("click", function() {
                    let value = this.getAttribute("data-value");
                    ratingInput.value = value;

                    // Highlight stars up to the selected one
                    stars.forEach(s => {
                        s.classList.toggle("selected", s.getAttribute("data-value") <=
                            value);
                    });
                });
            });
        });
    </script>
    <script>
        // Initialize Owl Carousel
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                loop: true, // Enable infinite looping
                margin: 10, // Spacing between items
                nav: false, // Show navigation arrows
                dots: false, // Hide dots
                responsive: {
                    0: {
                        items: 2
                    }, // Show 2 items on small screens
                    600: {
                        items: 4
                    }, // Show 3 items on medium screens
                    1000: {
                        items: 5
                    } // Show 4 items on large screens
                }
            });
        });

        // Function to change the main image
        function changeMainImage(thumbnail) {
            const mainImage = document.getElementById('mainImage');
            mainImage.src = thumbnail.src;

            // Optional: Add highlight effect to the active thumbnail
            document.querySelectorAll('.thumbnail').forEach(img => img.classList.remove('selected-thumbnail'));
            thumbnail.classList.add('selected-thumbnail');
        }
    </script>
    <script>
        // JavaScript to dynamically adjust dropdown alignment
        document.querySelectorAll('.dropdown-submenu').forEach(function(submenu) {
            submenu.addEventListener('mouseenter', function() {
                const submenuElement = submenu.querySelector('.dropdown-menu');
                const rect = submenuElement.getBoundingClientRect();

                // Check if submenu overflows the viewport
                if (rect.right > window.innerWidth) {
                    submenuElement.classList.add('left-align');
                } else {
                    submenuElement.classList.remove('left-align');
                }
            });
        });
    </script>
@endsection
