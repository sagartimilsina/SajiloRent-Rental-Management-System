@extends('frontend.layouts.main')
@section('title', 'Home')
@section('content')

    <main>
        <!-- Slider Section Start -->
        @if ($Sliders->count() > 0)
            <section class="slider-section">
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                    <div class="carousel-indicators">
                        @foreach ($Sliders as $index => $slider)
                            <button type="button" data-bs-target="#carouselExampleCaptions"
                                data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"
                                aria-current="{{ $index === 0 ? 'true' : '' }}"
                                aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach ($Sliders as $index => $slider)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $slider->slider_image) }}" class="d-block w-100"
                                    alt="{{ $slider->title }}">

                                <div class="carousel-caption d-none d-md-block">
                                    <p style="color: #fff!important">{{ $slider->sub_title }}</p>
                                    <h1 style="color: #fff !important">{{ $slider->title }}</h1>
                                    <a class="btn btn-md" href="{{ route('about') }}">Learn More</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </section>
        @endif

        <!-- Slider Section End -->
        <!-- We Provide Section Start -->
        @if ($categories->count() > 0)
            <section class="we-provide-section">
                <div class="text-center">
                    <h5 class="we-provide text-dark">We Provide</h5>
                </div>
                <div class="owl-carousel owl-theme" id="provide-carousel">

                    @foreach ($categories as $category)
                        <div class="item">
                            <div class="provide-icon">
                                <img src="{{ asset('storage/' . $category->icon) }}"
                                    style="width: 50px; height: 50px ; display: block; margin: 0 auto;"
                                    alt="{{ $category->icon }}">
                                <p style="font-size: 14px;">{{ $category->category_name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- We Provide Section End -->
        <!-- Availability Section Start -->
        <section class=" availibility-section">
            <div class="container py-5">
                <h1>For rates & Availability</h1>
                <h2>Search for Rent property</h2>
                {{-- <form class="row g-3 justify-content-center" action="{{ route('properties.search') }}" method="GET">
                    @csrf
                    <div class="col-md-3">
                        <label for="livingArea" class="form-label">Location</label>
                        <input type="text" class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}"
                            id="livingArea" name="location" placeholder="Where do you want ?">
                    </div>
                    <div class="col-md-3">
                        <label for="type" class="form-label">Category</label>
                        <select id="type" class="form-select {{ $errors->has('category') ? 'is-invalid' : '' }}"
                            required name="category_id">
                            <option selected>Select a Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="for" class="form-label">Sub Category</label>
                        <select id="for" class="form-select{{ $errors->has('sub_category') ? 'is-invalid' : '' }}"
                            required name="sub_category_id">
                            <option selected>Select a Sub Category</option>
                        </select>
                        @error('sub_category_id')
                            <div class="invalid-feedback">{{ $message }}
                            </div>
                        @enderror

                    </div>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#type').on('change', function() {
                                let categoryId = $(this).val();
                                // Clear the subcategory dropdown
                                $('#for').html('<option selected>Select a Sub Category</option>');

                                if (categoryId) {
                                    let url = "{{ route('get.subcategories', ':id') }}".replace(':id', categoryId);

                                    $.ajax({
                                        url: url,
                                        type: 'GET',
                                        success: function(response) {
                                            if (response && response.length > 0) {
                                                $.each(response, function(key, subCategory) {
                                                    $('#for').append(
                                                        `<option value="${subCategory.id}">${subCategory.sub_category_name}</option>`
                                                    );
                                                });
                                            } else {
                                                $('#for').append('<option>No Sub Categories Found</option>');
                                            }
                                        },
                                        error: function() {
                                            alert('Error fetching subcategories');
                                        },
                                    });
                                }
                            });
                        });
                    </script>



                    <div class="col-md-3">
                        <label for="priceMin" class="form-label">PRICE</label>
                        <div class="input-group">
                            <input type="text" class="form-control{{ $errors->has('min_price') ? 'is-invalid' : '' }}"
                                id="priceMin" name="min_price" placeholder="min">
                            <span class="input-group-text">-</span>
                            <input type="text" class="form-control{{ $errors->has('max_price') ? 'is-invalid' : '' }}"
                                id="priceMax" name="max_price" placeholder="max">
                        </div>
                    </div>


                    <div class="col-md-12 mt-4">
                        <button type="submit" class="btn btn-primary">Check Availability</button>
                    </div>
                </form> --}}

                <form class="row g-3 justify-content-center" action="{{ route('properties.search') }}" method="GET">
                    @csrf
                    <div class="col-md-3">
                        <label for="livingArea" class="form-label">Location</label>
                        <input type="text" class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}"
                            id="livingArea" name="location" placeholder="Where do you want ?">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="type" class="form-label">Category</label>
                        <select id="type" class="form-select {{ $errors->has('category_id') ? 'is-invalid' : '' }}"
                            required name="category_id">
                            <option selected>Select a Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="for" class="form-label">Sub Category</label>
                        <select id="for"
                            class="form-select {{ $errors->has('sub_category_id') ? 'is-invalid' : '' }}" required
                            name="sub_category_id">
                            <option selected>Select a Sub Category</option>
                        </select>
                        @error('sub_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="priceMin" class="form-label">PRICE</label>
                        <div class="input-group">
                            <input type="text" class="form-control {{ $errors->has('min_price') ? 'is-invalid' : '' }}"
                                id="priceMin" name="min_price" placeholder="min">
                            <span class="input-group-text">-</span>
                            <input type="text" class="form-control {{ $errors->has('max_price') ? 'is-invalid' : '' }}"
                                id="priceMax" name="max_price" placeholder="max">
                        </div>
                        @error('min_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('max_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12 mt-4">
                        <button type="submit" class="btn btn-primary">Check Availability</button>
                    </div>
                </form>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $('#type').on('change', function() {
                            let categoryId = $(this).val();
                            // Clear the subcategory dropdown
                            $('#for').html('<option selected>Select a Sub Category</option>');

                            if (categoryId) {
                                let url = "{{ route('get.subcategories', ':id') }}".replace(':id', categoryId);

                                $.ajax({
                                    url: url,
                                    type: 'GET',
                                    success: function(response) {
                                        if (response && response.length > 0) {
                                            $.each(response, function(key, subCategory) {
                                                $('#for').append(
                                                    `<option value="${subCategory.id}">${subCategory.sub_category_name}</option>`
                                                );
                                            });
                                        } else {
                                            $('#for').append('<option>No Sub Categories Found</option>');
                                        }
                                    },
                                    error: function() {
                                        alert('Error fetching subcategories');
                                    },
                                });
                            }
                        });
                    });
                </script>
            </div>
        </section>
        <!-- Availability Section End -->
        <!-- About Section Start -->
        <section class="about-section">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <h1 class="title text-dark">About Us</h1>

                    <p class="text-secondary fs-5">WELCOME TO Sajilo Rent</p>
                </div>

                <div class="row">
                    <!-- Sidebar Navigation -->
                    <!-- Sidebar Navigation -->
                    <div class="col-xl-2 col-lg-3 col-md-3 mb-4 position-relative">
                        <ul class="nav about-nav-responsive flex-column">
                            @foreach ($abouts as $index => $item)
                                <li class="nav-item{{ $index == 0 ? ' active-about-nav' : '' }} mb-3 me-3"
                                    onclick="showContent('{{ $item->id }}', this)">
                                    <h6 class="fw-bold text-left">
                                        {{ $item->head }}
                                    </h6>
                                </li>
                            @endforeach

                        </ul>
                    </div>

                    <!-- Content Area -->
                    <div class="col-xl-10 col-lg-9 col-md-9">
                        @foreach ($abouts as $index => $item)
                            <div class="content-section {{ $index == 0 ? '' : 'd-none' }}" id="{{ @$item->id }}">
                                <div class="row">
                                    <!-- Text Section -->
                                    <div class="{{ @$item->image != null ? 'col-lg-7 col-md-12' : 'col-12' }}">
                                        <p class="fs-5 mb-4 text-start">
                                            {!! \Illuminate\Support\Str::limit(strip_tags(@$item->description), 500, '...') !!}
                                        </p>

                                        <div class="btn" style="float: left;">
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('about_dynamic', $item->id) }}">Read More</a>
                                        </div>
                                    </div>

                                    <!-- Image Section -->
                                    @if (@$item->image != null)
                                        <div class="col-lg-5 col-md-12">
                                            <img class="img-fluid rounded shadow"
                                                src="{{ asset('storage/' . $item->image) }}" />
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach



                    </div>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        // Trigger showContent for the default active section
                        const defaultNavItem = document.querySelector('.nav-item.active-about-nav');
                        if (defaultNavItem) {
                            const defaultSectionId = defaultNavItem.getAttribute('onclick').match(/'([^']+)'/)[1];
                            showContent(defaultSectionId, defaultNavItem);
                        }
                    });

                    function showContent(sectionId, element) {
                        // Hide all content sections
                        const sections = document.querySelectorAll('.content-section');
                        sections.forEach(section => {
                            section.classList.add('d-none');
                        });

                        // Show the selected section
                        const targetSection = document.getElementById(sectionId);
                        if (targetSection) {
                            targetSection.classList.remove('d-none');
                        }

                        // Remove 'active-about-nav' class from all navigation items
                        const navItems = document.querySelectorAll('.nav-item');
                        navItems.forEach(item => {
                            item.classList.remove('active-about-nav');
                        });

                        // Add 'active-about-nav' class to the clicked nav item
                        if (element) {
                            element.classList.add('active-about-nav');
                        }
                    }
                </script>


                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        // Trigger showContent for the default active section
                        const defaultNavItem = document.querySelector('.nav-item.active-about-nav');
                        if (defaultNavItem) {
                            const defaultSectionId = defaultNavItem.getAttribute('onclick').match(/'([^']+)'/)[1];
                            showContent(defaultSectionId, defaultNavItem);
                        }
                    });

                    function showContent(sectionId, element) {
                        // Hide all content sections
                        const sections = document.querySelectorAll('.content-section');
                        sections.forEach(section => {
                            section.classList.add('d-none');
                        });

                        // Show the selected section
                        const targetSection = document.getElementById(sectionId);
                        if (targetSection) {
                            targetSection.classList.remove('d-none');
                        }

                        // Remove 'active-about-nav' class from all navigation items
                        const navItems = document.querySelectorAll('.nav-item');
                        navItems.forEach(item => {
                            item.classList.remove('active-about-nav');
                        });

                        // Add 'active-about-nav' class to the clicked nav item
                        if (element) {
                            element.classList.add('active-about-nav');
                        }
                    }
                </script>

            </div>
        </section>
        <!-- About Section End -->
        <!-- Rooms and property Section Start -->
        <section class="rent-property">
            <div class="container">
                <div class="header mb-5">
                    <h1>
                        Property and Product Rentals

                    </h1>
                    <p class="text-secondary fs-5 text-uppercase">
                        FIND YOUR Property and Product, FOR YOUR ABILITY

                </div>
                <div class="row">


                    @if ($apartments->count() > 0)
                        <div class="row">
                            @foreach ($apartments as $apartment)
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <a href="{{ route('property.details', ['id' => $apartment->id]) }}"
                                            class="text-decoration-none">
                                            <img alt="{{ $apartment->property_name }}" class="card-img-top img-fluid"
                                                src="{{ asset('storage/' . $apartment->property_image) }}" />
                                            <div class="card-body">
                                                <h5 class="card-title text-truncate">
                                                    {{ $apartment->property_name }}</h5>
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
                                                        Rs.
                                                        {{ $apartment->property_sell_price }}
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
                        </div>
                    @else
                        <div class="text-center py-5">
                            <p class="h5 text-muted">No properties available at the moment.</p>
                        </div>
                        <div class="text-center py-5">
                            <p class="h5 text-muted">No properties available at the moment.</p>
                        </div>
                    @endif






                </div>
                <div class="text-center mb-4">
                    <a href="#" class="btn btn-primary">
                        View All
                    </a>
                </div>
            </div>
        </section>

        <!-- Room and Apartments Section End -->


        <section class="achievement-section">
            <div class="container">
                <div class="row text-center">
                    <div class="col-lg-3 col-md-6">
                        <h1>1000+</h1>
                        <h2>Happy Customers</h2>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h1>500+</h1>
                        <h2>Projects Completed</h2>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h1>200+</h1>
                        <h2>Team Members</h2>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h1>50+</h1>
                        <h2>Awards Won</h2>
                    </div>
                </div>
            </div>
        </section>
        <!-- Achievement Section End -->
        <!-- Gallery Section Start -->
        <section class="gallery">
            <div class="container mt-5">
                <div class="row">
                    <!-- Gallery Images -->
                    <div class="col-xl-6 col-lg-8 col-md-12">
                        <div class="row">
                            @foreach ($galleries as $gallery)
                                <div class="col-4 mb-3">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal"
                                        data-bs-image="{{ asset($gallery->image_url) }}">
                                        <img alt="{{ $gallery->title }}" class="img-fluid gallery-image"
                                            src="{{ asset($gallery->image_url) }}" />
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Gallery Description -->
                    <div class="col-xl-6 col-md-12 col-lg-4 ">
                        <h1 class="gallery-title">
                            Our Photo Gallery
                        </h1>
                        <h2 class="gallery-subtitle">
                            Best of our Event Portfolio Photos
                        </h2>
                        <p class="gallery-description">
                            Amorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vitae nibh nisl. Cras ettikis
                            mauris
                            eget lorem ultricies fermentum a inti diam. Morbi mollis pellentesque offs aiugueia nec rhoncus.
                            Nam ute ultricies.
                        </p>
                        <button class="btn btn-primary btn-lg">
                            ALL PHOTOS &amp; VIDEO
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal for Image Preview -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="modalImage" src="" alt="Image Preview" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- JavaScript for Modal Image Handling -->
        <script>
            document.querySelectorAll('[data-bs-image]').forEach(imgLink => {
                imgLink.addEventListener('click', function() {
                    const imgSrc = this.getAttribute('data-bs-image');
                    const modalImg = document.getElementById('modalImage');
                    modalImg.setAttribute('src', imgSrc);
                });
            });
        </script>

        <!-- Gallery Section End -->
        <!-- list your property contact  starts-->

        <section class="list-your-section">
            <div class="container">
                <div class="row align-items-center justify-content-center text-center">
                    <div class="col-md-6">
                        <h1 class="fw-bold text-white">Do you want to rent your property?</h1>
                        <h6 class=" " style="color:#f39c12">Call us and list your property here.</h6>
                    </div>
                    <div class="col-md-6">
                        <h6>+977 9819113548</h6>
                        <h6>info.sajilorent@gmail.com</h6>
                        <a href="contact.html" class="btn btn-primary "> Contact Us</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- list your property contact  ends -->
        <!-- Testimonial Section Start -->
        <section class="container">
            <div class="testimonial-section">
                <h1>What Our Clients Say</h1>
                <h2>
                    <p><i class="fas fa-quote-right"></i></p>
                    Real feedback from our satisfied customers about their experiences.
                </h2>
                <div class="testimonial-container">
                    <div id="testimonial-carousel" class="owl-carousel owl-theme">
                        @foreach ($testimonials as $testimonial)
                            <div class="item">
                                <div class="testimonial-card">
                                    <img src="{{ asset('storage/' . $testimonial->image) }}"
                                        alt="{{ $testimonial->name }}">
                                    <img src="{{ asset('storage/' . $testimonial->image) }}"
                                        alt="{{ $testimonial->name }}">
                                    <h3>{{ $testimonial->name }}</h3>
                                    <h4>{{ $testimonial->position }}</h4>
                                    <p>{!! $testimonial->description !!}</p>
                                    <p>{!! $testimonial->description !!}</p>
                                    <div class="stars">
                                        @for ($i = 0; $i < $testimonial->rating; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                        @for ($i = $testimonial->rating; $i < 5; $i++)
                                            <i class="far fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonial Section End -->
        <!-- Available section start -->
        <section class="container">
            <div class="contact-section">
                <h1>We Are Available <br> For You 24/7</h1>
                <p>OUR ONLINE SUPPORT SERVICE IS ALWAYS 24 HOURS</p>
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="map-container">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509374!2d144.9537353153167!3d-37.8172099797517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577d1b1f4b0b1b!2sStone%20%26%20Chalk%20Melbourne%20Startup%20Hub!5e0!3m2!1sen!2sau!4v1633072871234!5m2!1sen!2sau"
                                width="600" height="450" style="border:0;" allowfullscreen=""
                                loading="lazy"></iframe>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-info">
                            <div class="row justify-content-between ">
                                <div class="mb-5 col-md-6 ">
                                    <h5> <i class="fas fa-map-marker-alt me-2"></i>Address</h5>
                                    <a href="#" class="text-decoration-none p">112/B - Road 121, King/St Melbourne
                                        Australia</a>
                                </div>
                                <div class="mb-5 col-md-6">
                                    <h5> <i class="fas fa-envelope me-2"></i>Mail</h5>
                                    <a href="mailto:yourmail@domain.com"
                                        class="text-decoration-none ">yourmail@domain.com</a> <br> <a
                                        href="mailto:houserent@domain.com"
                                        class="text-decoration-none ">houserent@domain.com</a>
                                </div>
                            </div>
                            <div class="row justify-content-between ">
                                <div class="mb-5 col-md-6">
                                    <h5> <i class="fas fa-phone-alt me-2"></i>Call</h5>
                                    <a href="tel:+99 0215469875" class="text-decoration-none ">+99 0215469875<br> <a
                                            href="tel:+88 0215469875" class="text-decoration-none "> +88 0215469875</a>
                                </div>
                                <div class="mb-5 col-md-6">
                                    <h5> <i class="fas fa-user me-2"></i>Social account</h5>
                                    <div class="social-icons">
                                        <a href="#"><i class="fab fa-facebook "></i></a>
                                        <a href="#"><i class="fab fa-twitter "></i></a>
                                        <a href="#"><i class="fab fa-instagram "></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Available section end -->
        <!-- Blogs Section Start -->
        @if (@$blogs->count() > 0)


            <section class="blog-section container">
                <div class="container text-center">
                    <h1 class="blog-title">Our Blogs</h1>
                    <p class="blog-subtitle">Discover the Latest Trends & Insights in Rental Living</p>
                </div>
                <div class="row">
                    @foreach ($blogs as $blog)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card blog-card">
                                <img alt="{{ $blog->alt_text ?? 'Blog Image' }}" class="card-img-top img-fluid"
                                    src="{{ asset('storage/' . $blog->blog_image) }}" />
                                <div class="card-body blog-card-body">
                                    <p class="blog-card-text">
                                        {{ $blog->created_at->format('F d, Y') }}
                                    </p>
                                    <h5 class="blog-card-title" style="height: 50px; overflow:hidden;">
                                        <a href="{{ route('blog.details', $blog->id) }}"
                                            class="text-wrap">{{ $blog->blog_title }}</a>
                                    </h5>
                                    <p class="text-wrap" style="height: 50px; overflow:hidden;">{!! substr(strip_tags($blog->blog_description), 0, 100) !!}...
                                    </p>


                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center my-4">
                    <a href="{{ route('blog') }}" class="btn btn-primary btn-sm">
                        Show All
                    </a>
                </div>
            </section>
        @endif

        <!-- Blogs Section End -->
    </main>
@endsection
